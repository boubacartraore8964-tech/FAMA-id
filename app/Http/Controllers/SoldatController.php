<?php

namespace App\Http\Controllers;

use App\Models\Soldat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SoldatController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');
    $statut = $request->input('statut');
    $unite = $request->input('unite');
    $base = $request->input('base');

    $query = Soldat::query();

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('nom', 'like', "%{$search}%")
              ->orWhere('prenom', 'like', "%{$search}%")
              ->orWhere('matricule', 'like', "%{$search}%");
        });
    }
    if ($statut) {
        $query->where('statut', $statut);
    }
    if ($unite) {
        $query->where('unite', $unite);
    }
    if ($base) {
        $query->where('base_affectation', $base);
    }

    $soldats = $query->latest()->paginate(10);

    $countTotal = Soldat::count();
    $countActif = Soldat::where('statut', 'actif')->count();
    $countSuspendu = Soldat::where('statut', 'suspendu')->count();
    $countEnAttente = Soldat::where('statut', 'en_attente')->count();
    
    $unites = Soldat::distinct()->whereNotNull('unite')->pluck('unite');
    $bases = Soldat::distinct()->whereNotNull('base_affectation')->pluck('base_affectation');

    return view('admin.soldats.index', compact('soldats', 'search', 'statut', 'countTotal', 'countActif', 'countSuspendu', 'countEnAttente', 'unites', 'bases'));
}
         

    public function create()
{
    $grades = Soldat::distinct()->whereNotNull('grade')->pluck('grade');
    $unites = Soldat::distinct()->whereNotNull('unite')->pluck('unite');
    $bases = Soldat::distinct()->whereNotNull('base_affectation')->pluck('base_affectation');
    
    return view('admin.soldats.create', compact('grades', 'unites', 'bases'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'matricule' => 'required|string|max:50|unique:soldats,matricule',
            'telephone' => 'nullable|string|max:20',
            'grade' => 'required|string|max:255',
            'unite' => 'required|string|max:255',
            'base_affectation' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'photo_profil_gauche' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo_profil_droit' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $imageBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($request->file('photo')->getRealPath()));
            try {
                $response = \Illuminate\Support\Facades\Http::timeout(10)->post('http://127.0.0.1:8001/check_face', ['image_base64' => $imageBase64]);
                if (!$response->json('valid')) {
                    return back()->withErrors(['photo' => 'La photo de face est invalide : ' . $response->json('message')])->withInput();
                }
            } catch (\Exception $e) {
                return back()->withErrors(['photo' => 'Erreur : Impossible de valider la photo avec l\'IA.'])->withInput();
            }
            $validated['photo_path'] = $request->file('photo')->store('soldats', 'public');
        }

        if ($request->hasFile('photo_profil_gauche')) {
            $validated['photo_profil_gauche'] = $request->file('photo_profil_gauche')->store('soldats', 'public');
        }
        if ($request->hasFile('photo_profil_droit')) {
            $validated['photo_profil_droit'] = $request->file('photo_profil_droit')->store('soldats', 'public');
        }

        Soldat::create($validated);
        return redirect()->route('soldats.index')->with('success', 'Soldat enregistré avec succès.');
    }

    public function show(Soldat $soldat)
{
    return view('admin.soldats.show', compact('soldat'));
}

    public function edit(Soldat $soldat)
{
    $grades = Soldat::distinct()->whereNotNull('grade')->pluck('grade');
    $unites = Soldat::distinct()->whereNotNull('unite')->pluck('unite');
    $bases = Soldat::distinct()->whereNotNull('base_affectation')->pluck('base_affectation');

    return view('admin.soldats.edit', compact('soldat', 'grades', 'unites', 'bases'));
}

    public function update(Request $request, Soldat $soldat)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'matricule' => 'required|string|max:50|unique:soldats,matricule,' . $soldat->id,
            'telephone' => 'nullable|string|max:20',
            'grade' => 'required|string|max:255',
            'unite' => 'required|string|max:255',
            'base_affectation' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo_profil_gauche' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo_profil_droit' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            Storage::disk('public')->delete($soldat->photo_path);
            $validated['photo_path'] = $request->file('photo')->store('soldats', 'public');
        }
        if ($request->hasFile('photo_profil_gauche')) {
            if ($soldat->photo_profil_gauche) Storage::disk('public')->delete($soldat->photo_profil_gauche);
            $validated['photo_profil_gauche'] = $request->file('photo_profil_gauche')->store('soldats', 'public');
        }
        if ($request->hasFile('photo_profil_droit')) {
            if ($soldat->photo_profil_droit) Storage::disk('public')->delete($soldat->photo_profil_droit);
            $validated['photo_profil_droit'] = $request->file('photo_profil_droit')->store('soldats', 'public');
        }

        $soldat->update($validated);
        return redirect()->route('soldats.index')->with('success', 'Informations du soldat mises à jour.');
    }

    public function toggleStatut(Soldat $soldat)
    {
        $nouveauStatut = $soldat->statut === 'actif' ? 'suspendu' : 'actif';
        $soldat->update(['statut' => $nouveauStatut]);
        $message = $nouveauStatut === 'suspendu' ? 'Le soldat a été suspendu.' : 'Le soldat a été réactivé.';
        return redirect()->route('soldats.index')->with('success', $message);
    }
    public function valider(Soldat $soldat)
{
    $soldat->update(['statut' => 'actif']);
    return redirect()->back()->with('success', 'Le soldat a été validé et est maintenant actif.');
}

    public function destroy(Soldat $soldat)
    {
        if ($soldat->photo_path) Storage::disk('public')->delete($soldat->photo_path);
        if ($soldat->photo_profil_gauche) Storage::disk('public')->delete($soldat->photo_profil_gauche);
        if ($soldat->photo_profil_droit) Storage::disk('public')->delete($soldat->photo_profil_droit);
        $soldat->delete();
        return redirect()->route('soldats.index')->with('success', 'Le soldat a été supprimé de la base de données.');
    }
}