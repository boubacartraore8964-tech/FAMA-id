@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('soldats.index') }}" class="text-muted text-decoration-none">Soldats</a>
            <span class="text-muted">/</span>
            <span class="fw-bold" style="color: var(--admin-text);">{{ $soldat->nom }} {{ $soldat->prenom }}</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('soldats.edit', $soldat->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Modifier</a>
            <form action="{{ route('soldats.toggle', $soldat->id) }}" method="POST" class="d-inline">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-sm btn-outline-warning">
                    <i class="bi bi-pause"></i> {{ $soldat->statut === 'actif' ? 'Suspendre' : 'Réactiver' }}
                </button>
            </form>
            <form action="{{ route('soldats.destroy', $soldat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce soldat ?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Supprimer</button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <!-- Colonne Info -->
        <div class="col-md-8">
            <div class="bg-white rounded-3 shadow-sm border p-4 h-100">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <img src="{{ asset('storage/' . $soldat->photo_path) }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                    <div>
                        <h4 class="fw-bold m-0">{{ $soldat->nom }} {{ $soldat->prenom }}</h4>
                        <div class="text-muted">{{ $soldat->grade }}, {{ $soldat->unite }}</div>
                    </div>
                    <div class="ms-auto">
                        @if($soldat->statut === 'actif')
                            <span class="badge bg-success bg-opacity-10 text-success" style="font-size: 0.9rem;">Actif</span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning" style="font-size: 0.9rem;">Suspendu</span>
                        @endif
                    </div>
                </div>

                <h6 class="fw-bold mb-3 mt-5">Identité</h6>
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted" style="width: 30%;">Matricule</td>
                        <td class="fw-medium">{{ $soldat->matricule }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Numéro</td>
                        <td class="fw-medium">{{ $soldat->telephone ?? 'Non renseigné' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Grade</td>
                        <td class="fw-medium">{{ $soldat->grade }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Unité</td>
                        <td class="fw-medium">{{ $soldat->unite }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Base d'affectation</td>
                        <td class="fw-medium">{{ $soldat->base_affectation }}</td>
                    </tr>
                </table>

                <h6 class="fw-bold mb-3 mt-4">Photos enregistrées</h6>
                <div class="d-flex gap-3">
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $soldat->photo_path) }}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="text-muted mt-1" style="font-size: 0.75rem;">Face</div>
                    </div>
                    @if($soldat->photo_profil_gauche)
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $soldat->photo_profil_gauche) }}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="text-muted mt-1" style="font-size: 0.75rem;">Profil G.</div>
                    </div>
                    @endif
                    @if($soldat->photo_profil_droit)
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $soldat->photo_profil_droit) }}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="text-muted mt-1" style="font-size: 0.75rem;">Profil D.</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Colonne Historique (Dynamique) -->
        <div class="col-md-4">
            <div class="bg-white rounded-3 shadow-sm border p-4 h-100">
                <h6 class="fw-bold mb-3">Dernières vérifications</h6>
                @forelse($soldat->verifications()->latest()->take(4)->get() as $verif)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="fw-medium" style="font-size: 0.85rem;">{{ $verif->verificateur->poste ?? 'Poste inconnu' }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ $verif->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        @if($verif->resultat === 'reconnu')
                            <span class="badge bg-success bg-opacity-10 text-success">Reconnu</span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger">Refusé</span>
                        @endif
                    </div>
                @empty
                    <div class="text-muted text-center py-4" style="font-size: 0.85rem;">Aucune vérification.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection