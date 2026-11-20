<?php

namespace App\Http\Controllers;

use App\Models\Soldat;
use App\Models\Verification;
use App\Models\Alerte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ScanController extends Controller
{
    public function dashboard()
    {
        $verificationsJour = Verification::where('verificateur_id', Auth::id())
                                ->whereDate('created_at', today())->count();
                                
        $refusesJour = Verification::where('verificateur_id', Auth::id())
                                ->whereDate('created_at', today())
                                ->where('resultat', '!=', 'reconnu')->count();

        $dernieresVerifications = Verification::where('verificateur_id', Auth::id())
                                ->with('soldat')
                                ->latest()
                                ->take(3)
                                ->get();

        return view('verificateur.dashboard', compact('verificationsJour', 'refusesJour', 'dernieresVerifications'));
    }

    public function camera()
    {
        return view('verificateur.camera');
    }

    public function processScan(Request $request)
    {
        $matricule = $request->input('matricule_saisi');
        $soldat = Soldat::where('matricule', $matricule)->first();

        if (!$soldat) {
            return back()->withErrors(['error' => 'Matricule introuvable dans la base de données.']);
        }

        $imageBase64 = $request->input('image_base64');
        $agent = Auth::user();

        if (!$imageBase64) {
            return back()->withErrors(['error' => 'Aucune image capturée par la caméra.']);
        }

        $photoPath = storage_path('app/public/' . $soldat->photo_path);
        if (!file_exists($photoPath)) {
            return back()->withErrors(['error' => 'Photo du soldat introuvable.']);
        }
        $imageSoldatBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($photoPath));

        $imageGaucheBase64 = null;
        if ($soldat->photo_profil_gauche) {
            $pathGauche = storage_path('app/public/' . $soldat->photo_profil_gauche);
            if (file_exists($pathGauche)) {
                $imageGaucheBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($pathGauche));
            }
        }

        $imageDroitBase64 = null;
        if ($soldat->photo_profil_droit) {
            $pathDroit = storage_path('app/public/' . $soldat->photo_profil_droit);
            if (file_exists($pathDroit)) {
                $imageDroitBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($pathDroit));
            }
        }

        $distance = 1.0;

        try {
            $response = Http::timeout(60)->post('http://127.0.0.1:8001/verify', [
                'img_scan_base64' => $imageBase64,
                'img_face_base64' => $imageSoldatBase64,
                'img_gauche_base64' => $imageGaucheBase64,
                'img_droit_base64' => $imageDroitBase64,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $resultat = $data['verified'] ? 'reconnu' : 'non_reconnu';
                $distance = $data['distance'] ?? 1.0;
            } else {
                return back()->withErrors(['error' => 'Erreur DeepFace : ' . $response->body()]);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Impossible de contacter le serveur IA. Vérifiez que Python (uvicorn) est lancé.']);
        }

        $photoScanPath = null;
        if ($imageBase64) {
            $imageParts = explode(";base64,", $imageBase64);
            if (count($imageParts) == 2) {
                $imageBase64Decoded = base64_decode($imageParts[1]);
                $fileName = 'scan_' . time() . '_' . uniqid() . '.jpg';
                Storage::disk('public')->put('scans/' . $fileName, $imageBase64Decoded);
                $photoScanPath = 'scans/' . $fileName;
            }
        }

        $verification = Verification::create([
            'verificateur_id' => $agent->id,
            'soldat_id' => $resultat === 'reconnu' ? $soldat->id : null,
            'resultat' => $resultat,
            'date_heure' => Carbon::now(),
            'photo_scan_path' => $photoScanPath,
        ]);

        if ($resultat !== 'reconnu') {
            Alerte::create([
                'verification_id' => $verification->id,
                'type' => 'inconnu',
                'message' => 'Le visage scanné ne correspond pas au soldat ' . $soldat->nom . '.',
                'statut' => 'ouverte',
            ]);
        }

        return redirect()->route('verificateur.result', $verification->id)->with('distance', $distance);
    }

    public function appelChef(Verification $verification)
    {
        Alerte::create([
            'verification_id' => $verification->id,
            'type' => 'inconnu',
            'message' => 'URGENCE : L\'agent ' . Auth::user()->name . ' demande une assistance immédiate au poste.',
            'statut' => 'ouverte',
        ]);

        return response()->json(['success' => true]);
    }

    public function result(Verification $verification)
    {
        $verification->load('soldat');
        $distance = session('distance', 0.01);
        return view('verificateur.result', compact('verification', 'distance'));
    }

    public function historique()
    {
        $verifications = Verification::where('verificateur_id', Auth::id())
            ->with('soldat')
            ->latest()
            ->paginate(10);

        return view('verificateur.historique', compact('verifications'));
    }
}