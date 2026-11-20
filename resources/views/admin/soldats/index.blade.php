@extends('layouts.app')

<style>
    .tab-link {
        color: #6B7280;
        text-decoration: none;
        font-weight: 500;
        padding-bottom: 8px;
        border-bottom: 2px solid transparent;
        font-size: 0.9rem;
    }
    .tab-link:hover { color: var(--admin-text); }
    .tab-link.active { color: var(--admin-text); border-bottom: 2px solid var(--admin-green); }
    .badge-status { padding: 5px 10px; border-radius: 6px; font-weight: 500; font-size: 0.75rem; }
</style>

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0">Soldats</h4>
        <a href="{{ route('soldats.create') }}" class="btn btn-sm text-white px-3 py-2" style="background-color: var(--admin-green); border-radius: 6px;">
            <i class="bi bi-plus-lg"></i> Enregistrer un soldat
        </a>
    </div>

    <div class="d-flex gap-4 border-bottom mb-3 pb-2">
        <a href="{{ route('soldats.index') }}" class="tab-link {{ !request('statut') ? 'active' : '' }}">
            Tous ({{ $countTotal }})
        </a>
        <a href="{{ route('soldats.index', ['statut' => 'actif']) }}" class="tab-link {{ request('statut') === 'actif' ? 'active' : '' }}">
            Actifs ({{ $countActif }})
        </a>
        <a href="{{ route('soldats.index', ['statut' => 'en_attente']) }}" class="tab-link {{ request('statut') === 'en_attente' ? 'active' : '' }}">
    En attente ({{ $countEnAttente }})
</a>
        <a href="{{ route('soldats.index', ['statut' => 'suspendu']) }}" class="tab-link {{ request('statut') === 'suspendu' ? 'active' : '' }}">
            Suspendus ({{ $countSuspendu }})
        </a>
    </div>

    <form action="{{ route('soldats.index') }}" method="GET" class="d-flex justify-content-between mb-3">
        <input type="hidden" name="statut" value="{{ request('statut') }}">
        <div class="d-flex gap-2">
            <select name="unite" class="form-select form-select-sm" style="width: 150px;" onchange="this.form.submit()">
                <option value="">Toutes les unités</option>
                @foreach($unites as $u)
                    <option value="{{ $u }}" {{ request('unite') == $u ? 'selected' : '' }}>{{ $u }}</option>
                @endforeach
            </select>
            <select name="base" class="form-select form-select-sm" style="width: 150px;" onchange="this.form.submit()">
                <option value="">Toutes les bases</option>
                @foreach($bases as $b)
                    <option value="{{ $b }}" {{ request('base') == $b ? 'selected' : '' }}>{{ $b }}</option>
                @endforeach
            </select>
        </div>
        <div class="d-flex">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Rechercher un soldat..." value="{{ $search ?? '' }}" style="width: 250px;">
            <button type="submit" class="btn btn-sm btn-outline-secondary ms-1"><i class="bi bi-search"></i></button>
        </div>
    </form>

    <div class="bg-white rounded-3 shadow-sm border">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 text-muted fw-normal ps-4 py-3" style="font-size: 0.85rem;">Soldat</th>
                        <th class="border-0 text-muted fw-normal py-3" style="font-size: 0.85rem;">Matricule</th>
                        <th class="border-0 text-muted fw-normal py-3" style="font-size: 0.85rem;">Unité</th>
                        <th class="border-0 text-muted fw-normal py-3" style="font-size: 0.85rem;">Base</th>
                        <th class="border-0 text-muted fw-normal py-3" style="font-size: 0.85rem;">Statut</th>
                        <th class="border-0 text-muted fw-normal py-3 pe-4 text-end" style="font-size: 0.85rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($soldats as $soldat)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('storage/' . $soldat->photo_path) }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold" style="font-size: 0.9rem;">{{ $soldat->nom }} {{ $soldat->prenom }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">{{ $soldat->grade }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size: 0.9rem;">{{ $soldat->matricule }}</td>
                            <td style="font-size: 0.9rem;">{{ $soldat->unite }}</td>
                            <td style="font-size: 0.9rem;">{{ $soldat->base_affectation }}</td>
                            <td>
                                @if($soldat->statut === 'actif')
                                    <span class="badge bg-success bg-opacity-10 text-success badge-status">Actif</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning badge-status">Suspendu</span>
                                @endif
                            </td>
                         <td class="pe-4 text-end">
    <div class="dropdown">
    <button class="btn btn-sm btn-light border" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-three-dots"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
        
        @if($soldat->statut === 'en_attente')
            <li>
                <form action="{{ route('soldats.valider', $soldat->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" class="dropdown-item text-success fw-bold">
                        <i class="bi bi-check-circle me-2"></i> Valider l'inscription
                    </button>
                </form>
            </li>
            <li><hr class="dropdown-divider"></li>
        @else
            <li>
                <a class="dropdown-item" href="{{ route('soldats.show', $soldat->id) }}">
                    <i class="bi bi-eye me-2 text-secondary"></i> Voir
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('soldats.edit', $soldat->id) }}">
                    <i class="bi bi-pencil me-2 text-primary"></i> Modifier
                </a>
            </li>
            <li>
                <form action="{{ route('soldats.toggle', $soldat->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" class="dropdown-item">
                        @if($soldat->statut === 'actif')
                            <i class="bi bi-pause me-2 text-warning"></i> Suspendre
                        @else
                            <i class="bi bi-play me-2 text-success"></i> Réactiver
                        @endif
                    </button>
                </form>
            </li>
            <li><hr class="dropdown-divider"></li>
        @endif
        
        <li>
            <form action="{{ route('soldats.destroy', $soldat->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce soldat ?');">
                @csrf @method('DELETE')
                <button type="submit" class="dropdown-item text-danger">
                    <i class="bi bi-trash me-2"></i> Supprimer
                </button>
            </form>
        </li>
    </ul>
</div>
</td>
        
           
                                       
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">Aucun soldat trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top">
            {{ $soldats->links() }}
        </div>
    </div>
@endsection