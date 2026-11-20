<?php

namespace App\Http\Controllers;

use App\Models\Soldat;
use App\Models\Verification;
use App\Models\Alerte;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
{
    $totalSoldats = \App\Models\Soldat::count();
    $verificationsJour = \App\Models\Verification::whereDate('created_at', today())->count();
    $alertesOuvertes = \App\Models\Alerte::where('statut', 'ouverte')->count();

    $dernieresAlertes = \App\Models\Alerte::with(['verification'])
        ->latest()
        ->take(3)
        ->get();

    $verificationsParHeure = \App\Models\Verification::whereDate('created_at', today())
        ->selectRaw('HOUR(created_at) as hour, count(*) as count')
        ->groupBy('hour')
        ->orderBy('hour')
        ->pluck('count', 'hour');

    $chartLabels = [];
    $chartData = [];
    for($i = 0; $i < 24; $i++) {
        $chartLabels[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ' h';
        $chartData[] = $verificationsParHeure->get($i, 0);
    }

    return view('admin.dashboard', compact(
        'totalSoldats', 
        'verificationsJour', 
        'alertesOuvertes', 
        'dernieresAlertes',
        'chartLabels',
        'chartData'
    ));
}
}