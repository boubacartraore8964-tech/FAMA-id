@extends('layouts.mobile')

@section('content')
    <div class="w-100" style="max-width: 400px;">
        <div class="d-flex align-items-center gap-2 mb-4 p-2 rounded" style="background-color: var(--fama-surface);">
            <i class="bi bi-journal-text text-warning"></i>
            <span class="fw-bold">Historique du poste</span>
        </div>

        <h6 class="text-muted mb-3" style="font-size: 0.8rem;">Aujourd'hui</h6>

        <div class="d-flex flex-column gap-2">
            @forelse($verifications ?? [] as $verif)
                <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background-color: var(--fama-surface);">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-person-circle fs-4 text-muted"></i>
                        <div>
                            <div style="font-size: 0.85rem;">
                                @if($verif->soldat) {{ $verif->soldat->nom }} @else Visage inconnu @endif
                            </div>
                            <div style="font-size: 0.7rem; color: var(--fama-muted);">{{ $verif->created_at->format('H:i') }}, score 98 %</div>
                        </div>
                    </div>
                    @if($verif->resultat === 'reconnu')
                        <span class="badge" style="background-color: rgba(74, 222, 128, 0.2); color: var(--fama-green-light); font-weight: normal;">Reconnu</span>
                    @else
                        <span class="badge" style="background-color: rgba(239, 68, 68, 0.2); color: var(--fama-danger); font-weight: normal;">Non reconnu</span>
                    @endif
                </div>
            @empty
                <div class="text-center text-muted p-4">
                    Aucune vérification récente.
                </div>
            @endforelse
        </div>
    </div>
@endsection