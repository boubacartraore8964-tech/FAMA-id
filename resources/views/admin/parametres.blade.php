@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0">Paramètres du Système</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <!-- Sécurité -->
        <div class="col-md-6 mb-4">
            <div class="bg-white rounded-3 shadow-sm border p-4 h-100">
                <h6 class="fw-bold mb-4"><i class="bi bi-shield-lock text-success me-2"></i> Sécurité du Compte</h6>
                
                <form action="{{ route('parametres.password') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted" style="font-size: 0.85rem;">Mot de passe actuel</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted" style="font-size: 0.85rem;">Nouveau mot de passe (Min. 8 caractères)</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted" style="font-size: 0.85rem;">Confirmer le nouveau mot de passe</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn text-white" style="background-color: var(--admin-green);">Mettre à jour le mot de passe</button>
                </form>
            </div>
        </div>

        <!-- Préférences Système (Design pro) -->
        <div class="col-md-6 mb-4">
            <div class="bg-white rounded-3 shadow-sm border p-4 h-100">
                <h6 class="fw-bold mb-4"><i class="bi bi-sliders text-success me-2"></i> Préférences Système</h6>
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <div class="fw-medium" style="font-size: 0.9rem;">Alertes Sonores</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Jouer un son lors d'un refus d'accès</div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <div class="fw-medium" style="font-size: 0.9rem;">Mode Maintenance</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Bloquer l'accès aux vérificateurs</div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <div class="fw-medium" style="font-size: 0.9rem;">Sauvegarde Automatique</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Sauvegarder la base de données chaque nuit</div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked>
                    </div>
                </div>

                <hr>
                <div class="text-end mt-4">
                    <!-- Bouton Enregistrer (Visuel pour l'instant) -->
                    <button type="button" class="btn text-white" style="background-color: var(--admin-green);" onclick="alert('Paramètres système sauvegardés avec succès !')">
                        Enregistrer les préférences
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Gestion du compte Soldat -->
<div class="col-md-6 mb-4">
    <div class="bg-white rounded-3 shadow-sm border p-4 h-100">
        <h6 class="fw-bold mb-4"><i class="bi bi-people text-success me-2"></i> Compte Global Soldat</h6>
        <p class="text-muted" style="font-size: 0.8rem;">Modifiez les accès du guichet d'inscription des soldats.</p>
        
        <form action="{{ route('parametres.soldat') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label text-muted" style="font-size: 0.85rem;">Identifiant (Email)</label>
                <input type="text" name="soldat_email" class="form-control" value="{{ \App\Models\User::where('role', 'soldat')->first()->email ?? 'soldat' }}" required>
            </div>
            <div class="mb-4">
                <label class="form-label text-muted" style="font-size: 0.85rem;">Nouveau mot de passe (Laisser vide pour ne pas changer)</label>
                <input type="text" name="soldat_password" class="form-control" placeholder="Ex: soldat2026">
            </div>
            <button type="submit" class="btn text-white" style="background-color: var(--admin-green);">Mettre à jour le compte soldat</button>
        </form>
    </div>
</div> 
@endsection