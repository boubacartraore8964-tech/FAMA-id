@extends('layouts.app')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Gestion des Vérificateurs</h1>
    <a href="{{ route('verificateurs.create') }}" class="btn btn-fama">
        <i class="bi bi-plus-lg"></i> Nouveau Vérificateur
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nom complet</th>
                        <th>Identifiant (Email)</th>
                        <th>Poste affecté</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($verificateurs as $verif)
                        <tr>
                            <td><strong>{{ $verif->name }}</strong></td>
                            <td>{{ $verif->email }}</td>
                            <td><span class="badge bg-secondary">{{ $verif->poste }}</span></td>
                            <td>
                                @if($verif->is_active)
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-danger">Inactif</span>
                                @endif
                            </td>
                            <td>
    <div class="d-flex gap-2">
        <a href="{{ route('verificateurs.edit', $verif->id) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
            <i class="bi bi-pencil"></i>
        </a>
        <form action="{{ route('verificateurs.destroy', $verif->id) }}" method="POST" onsubmit="return confirm('Supprimer ce compte vérificateur ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Aucun vérificateur enregistré.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $verificateurs->links() }}
        </div>
    </div>
</div>
@endsection