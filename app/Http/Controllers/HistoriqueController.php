<?php

namespace App\Http\Controllers;

use App\Models\Verification;
use App\Models\Alerte;
use Illuminate\Http\Request;

class HistoriqueController extends Controller
{
   public function index(Request $request)
{
    $resultat = $request->input('resultat');
    $poste = $request->input('poste');
    $date = $request->input('date');

    $verifications = Verification::with(['soldat', 'verificateur'])
        ->when($resultat, function ($query, $resultat) {
            return $query->where('resultat', $resultat);
        })
        ->when($poste, function ($query, $poste) {
            return $query->whereHas('verificateur', function($q) use ($poste) {
                $q->where('poste', $poste);
            });
        })
        ->when($date === 'today', function ($query) {
            return $query->whereDate('date_heure', today());
        })
        ->orderBy('date_heure', 'desc')
        ->paginate(15);
        
    $postes = \App\Models\User::where('role', 'verificateur')->distinct()->pluck('poste')->filter();

    return view('admin.historique', compact('verifications', 'resultat', 'poste', 'date', 'postes'));
}

    public function alertes(Request $request)
    {
        $statut = $request->input('statut', 'ouverte');
        
        $alertes = Alerte::with(['verification.soldat', 'verification.verificateur'])
            ->where('statut', $statut)
            ->orderBy('created_at', 'desc')
            ->get();

        $selectedAlerte = null;
        if ($request->has('id')) {
            $selectedAlerte = Alerte::with(['verification.soldat', 'verification.verificateur'])->find($request->id);
        } elseif ($alertes->count() > 0) {
            $selectedAlerte = $alertes->first();
        }

        return view('admin.alertes', compact('alertes', 'statut', 'selectedAlerte'));
    }

    public function traiterAlerte(Alerte $alerte)
    {
        $alerte->update(['statut' => 'traitee']);
        return redirect()->back()->with('success', 'L\'alerte a été marquée comme traitée.');
    }
}