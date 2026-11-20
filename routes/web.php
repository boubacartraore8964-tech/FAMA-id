<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\InscriptionController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
    // --- ESPACE ADMIN ---
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        Route::get('/parametres', [App\Http\Controllers\ParametreController::class, 'index'])->name('parametres.index');
        Route::post('/parametres/password', [App\Http\Controllers\ParametreController::class, 'updatePassword'])->name('parametres.password');
        Route::post('/parametres/soldat', [App\Http\Controllers\ParametreController::class, 'updateSoldierCredentials'])->name('parametres.soldat');
        
        Route::resource('soldats', App\Http\Controllers\SoldatController::class);
        Route::patch('/soldats/{soldat}/toggle-statut', [App\Http\Controllers\SoldatController::class, 'toggleStatut'])->name('soldats.toggle');
        Route::patch('/soldats/{soldat}/valider', [App\Http\Controllers\SoldatController::class, 'valider'])->name('soldats.valider');
        
        Route::resource('verificateurs', App\Http\Controllers\VerificateurController::class);
        
        Route::get('/historique', [App\Http\Controllers\HistoriqueController::class, 'index'])->name('historique.index');
        Route::get('/alertes', [App\Http\Controllers\HistoriqueController::class, 'alertes'])->name('alertes.index');
        Route::patch('/alertes/{alerte}/traiter', [App\Http\Controllers\HistoriqueController::class, 'traiterAlerte'])->name('alertes.traiter');
    });


    // --- ESPACE VÉRIFICATEUR ---
    Route::prefix('verificateur')->group(function () {
        Route::get('/dashboard', [ScanController::class, 'dashboard'])->name('verificateur.dashboard');
        Route::get('/camera', [ScanController::class, 'camera'])->name('verificateur.camera');
        Route::post('/scan', [ScanController::class, 'processScan'])->name('verificateur.scan');
        Route::get('/resultat/{verification}', [ScanController::class, 'result'])->name('verificateur.result');
        Route::get('/historique', [ScanController::class, 'historique'])->name('verificateur.historique');
        Route::post('/appel-chef/{verification}', [ScanController::class, 'appelChef'])->name('verificateur.appel_chef');
    });

    // --- ESPACE SOLDAT (Compte Global) ---
Route::prefix('soldat')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\InscriptionController::class, 'soldierDashboard'])->name('soldat.dashboard');
    
    // Les routes manquantes pour le formulaire :
    Route::post('/inscription', [App\Http\Controllers\InscriptionController::class, 'store'])->name('inscription.store');
    Route::get('/inscription-reussie', [App\Http\Controllers\InscriptionController::class, 'success'])->name('inscription.success');
});
});
