@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0">Alertes</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex gap-4 border-bottom mb-4">
        <a href="{{ route('alertes.index', ['statut' => 'ouverte']) }}" class="text-decoration-none fw-bold pb-2" style="{{ $statut === 'ouverte' ? 'color: var(--admin-text); border-bottom: 2px solid var(--admin-green);' : 'color: #6B7280; border-bottom: 2px solid transparent;' }}">
            Ouvertes
        </a>
        <a href="{{ route('alertes.index', ['statut' => 'traitee']) }}" class="text-decoration-none fw-bold pb-2" style="{{ $statut === 'traitee' ? 'color: var(--admin-text); border-bottom: 2px solid var(--admin-green);' : 'color: #6B7280; border-bottom: 2px solid transparent;' }}">
            Traitées
        </a>
    </div>

    <div class="row g-4">
        <!-- Liste des alertes (Gauche) -->
        <div class="col-md-5">
            <div class="d-flex flex-column gap-2">
                @forelse($alertes as $alerte)
                    <a href="{{ route('alertes.index', ['statut' => $statut, 'id' => $alerte->id]) }}" class="text-decoration-none">
                        <!-- J'ai mis un fond légèrement rouge (#FEF2F2) pour les alertes ouvertes -->
                        <div class="p-3 rounded-3 border" style="background-color: {{ $statut === 'ouverte' ? '#FEF2F2' : 'white' }}; border-color: {{ $selectedAlerte && $selectedAlerte->id === $alerte->id ? '#EF4444' : 'var(--admin-border)' }} !important;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                                        <i class="bi bi-exclamation-triangle text-danger"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold" style="font-size: 0.9rem; color: var(--admin-text);">{{ $alerte->message }}</div>
                                        <div style="font-size: 0.75rem; color: #6B7280;">{{ $alerte->verification->verificateur->name ?? 'Système' }} - {{ $alerte->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>
                                @if($alerte->statut === 'ouverte')
                                    <span class="badge bg-danger text-white badge-status">Non traitée</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center text-muted py-5 bg-white rounded-3 border">
                        <i class="bi bi-shield-check fs-1 d-block mb-2 text-success"></i>
                        Aucune alerte dans cette catégorie.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Détails de l'alerte (Droite) -->
        <div class="col-md-7">
            @if($selectedAlerte)
                <div class="bg-white rounded-3 shadow-sm border p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <h6 class="fw-bold m-0">Détails de l'alerte</h6>
                        @if($selectedAlerte->statut === 'ouverte')
                            <span class="badge bg-danger text-white badge-status">Ouverte</span>
                        @else
                            <span class="badge bg-success text-white badge-status">Traitée</span>
                        @endif
                    </div>

                    <div class="row mb-4">
                        <div class="col-4 text-center">
                            <!-- Affichage de la photo avec vérification stricte -->
                            @if($selectedAlerte->verification && $selectedAlerte->verification->photo_scan_path && file_exists(storage_path('app/public/' . $selectedAlerte->verification->photo_scan_path)))
                                <img src="{{ asset('storage/' . $selectedAlerte->verification->photo_scan_path) }}" class="img-fluid rounded" style="border: 2px solid #EF4444;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <div class="text-center text-muted">
                                        <i class="bi bi-person-x fs-1 d-block"></i>
                                        <span style="font-size: 0.7rem;">Aucune photo</span>
                                    </div>
                                </div>
                            @endif
                            <div class="mt-2 text-muted fw-bold" style="font-size: 0.8rem;">Photo capturée</div>
                        </div>
                        <div class="col-8">
                            <table class="table table-sm table-borderless" style="font-size: 0.9rem;">
                                <tr>
                                    <td class="text-muted" style="width: 40%;">Poste</td>
                                    <td class="fw-medium">{{ $selectedAlerte->verification->verificateur->poste ?? 'Non défini' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Vérificateur</td>
                                    <td class="fw-medium">{{ $selectedAlerte->verification->verificateur->name ?? 'Inconnu' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Date et heure</td>
                                    <td class="fw-medium">{{ $selectedAlerte->created_at->format('d/m/Y à H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Type</td>
                                    <td class="fw-medium"><span class="badge bg-warning text-dark">{{ ucfirst($selectedAlerte->type) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Contrôle du vivant</td>
                                    <td class="fw-medium text-success">Réussi</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-auto">
                        <form action="{{ route('alertes.traiter', $selectedAlerte->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn text-white px-4 py-2" style="background-color: var(--admin-green);" {{ $selectedAlerte->statut === 'traitee' ? 'disabled' : '' }}>
                                Marquer comme traitée
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-3 shadow-sm border p-5 h-100 d-flex flex-column align-items-center justify-content-center text-muted">
                    <i class="bi bi-envelope-open fs-1 mb-3"></i>
                    <h6>Sélectionnez une alerte</h6>
                    <p class="text-center mb-0" style="font-size: 0.85rem;">Cliquez sur une alerte à gauche pour voir les détails.</p>
                </div>
            @endif
        </div>
    </div>
@endsection