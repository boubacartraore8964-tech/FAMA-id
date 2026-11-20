<?php

namespace App\Http\Controllers;

use App\Models\Soldat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InscriptionController extends Controller
{
    public function soldierDashboard()
    {
        $grades = Soldat::distinct()->whereNotNull('grade')->pluck('grade');
        $unites = Soldat::distinct()->whereNotNull('unite')->pluck('unite');
        $bases = Soldat::distinct()->whereNotNull('base_affectation')->pluck('base_affectation');
        
        return view('soldat.dashboard', compact('grades', 'unites', 'bases'));
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
                $response = Http::timeout(10)->post('http://127.0.0.1:8001/check_face', ['image_base64' => $imageBase64]);
                if (!$response->json('valid')) {
                    return back()->withErrors(['photo' => 'Photo invalide : ' . $response->json('message')])->withInput();
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

        $validated['statut'] = 'en_attente';
        Soldat::create($validated);

        return redirect()->route('inscription.success')->with('nom', $validated['nom']);
    }

    public function success()
    {
        return view('inscription_success');
    }
}