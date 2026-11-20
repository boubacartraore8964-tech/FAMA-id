@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0">Historique des vérifications</h4>
        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-download"></i> Exporter</button>
    </div>

   <form action="{{ route('historique.index') }}" method="GET" class="d-flex justify-content-between mb-3">
    <div class="d-flex gap-2">
        <select name="poste" class="form-select form-select-sm" style="width: 180px; border-radius: 6px;" onchange="this.form.submit()">
            <option value="">Tous les postes</option>
            @foreach($postes as $p)
                <option value="{{ $p }}" {{ request('poste') == $p ? 'selected' : '' }}>{{ $p }}</option>
            @endforeach
        </select>

        <select name="resultat" class="form-select form-select-sm" style="width: 180px; border-radius: 6px;" onchange="this.form.submit()">
            <option value="">Tous les résultats</option>
            <option value="reconnu" {{ request('resultat') === 'reconnu' ? 'selected' : '' }}>Reconnu</option>
            <option value="non_reconnu" {{ request('resultat') === 'non_reconnu' ? 'selected' : '' }}>Non reconnu</option>
            <option value="fraude" {{ request('resultat') === 'fraude' ? 'selected' : '' }}>Fraude</option>
            <option value="suspendu" {{ request('resultat') === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
        </select>

        <select name="date" class="form-select form-select-sm" style="width: 150px; border-radius: 6px;" onchange="this.form.submit()">
            <option value="">Toutes les dates</option>
            <option value="today" {{ request('date') === 'today' ? 'selected' : '' }}>Aujourd'hui</option>
        </select>
    </div>
</form>

    <div class="bg-white rounded-3 shadow-sm border" style="border-color: var(--admin-border) !important;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 text-muted fw-normal" style="font-size: 0.85rem; padding: 15px 20px;">Date et heure</th>
                        <th class="border-0 text-muted fw-normal" style="font-size: 0.85rem;">Poste</th>
                        <th class="border-0 text-muted fw-normal" style="font-size: 0.85rem;">Vérificateur</th>
                        <th class="border-0 text-muted fw-normal" style="font-size: 0.85rem;">Personne</th>
                        <th class="border-0 text-muted fw-normal" style="font-size: 0.85rem;">Score</th>
                        <th class="border-0 text-muted fw-normal" style="font-size: 0.85rem; text-align: right; padding-right: 20px;">Résultat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($verifications as $verif)
                        <tr>
                            <td style="padding: 15px 20px; font-size: 0.9rem;">
                                {{ \Carbon\Carbon::parse($verif->date_heure)->format('d/m/Y, H:i') }}
                            </td>
                            <td style="font-size: 0.9rem;">{{ $verif->verificateur->poste ?? 'N/A' }}</td>
                            <td style="font-size: 0.9rem;">{{ $verif->verificateur->name ?? 'Système' }}</td>
                            <td style="font-size: 0.9rem;">
                                @if($verif->soldat)
                                    {{ $verif->soldat->nom }} {{ $verif->soldat->prenom }}
                                @else
                                    <span class="text-muted">Visage inconnu</span>
                                @endif
                            </td>
                            <td style="font-size: 0.9rem;">-- %</td>
                            <td style="text-align: right; padding-right: 20px;">
                                @if($verif->resultat === 'reconnu')
                                    <span class="badge bg-success bg-opacity-10 text-success badge-status">Reconnu</span>
                                @elseif($verif->resultat === 'non_reconnu')
                                    <span class="badge bg-danger bg-opacity-10 text-danger badge-status">Non reconnu</span>
                                @else
                                    <span class="badge bg-dark bg-opacity-10 text-dark badge-status">Fraude</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">Aucune vérification trouvée pour ces critères.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top">
            {{ $verifications->appends(request()->query())->links() }}
        </div>
    </div>
@endsection