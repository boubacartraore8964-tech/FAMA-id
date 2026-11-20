@extends('layouts.mobile')

@section('content')
    <div class="w-100 p-4 mb-4" style="background-color: #1A2018; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);">
        <h4 class="text-white fw-bold mb-4" style="font-size: 1.3rem;">Une personne se présente ?</h4>
        <a href="{{ route('verificateur.camera') }}" class="btn w-100 py-3 d-flex align-items-center justify-content-center gap-2" style="background-color: #F4F5F0; color: #1A2018; border-radius: 10px; font-weight: 600;">
            <i class="bi bi-camera"></i> Vérifier un visage
        </a>
    </div>

    <div class="w-100 d-flex gap-3 mb-4">
        <div class="flex-fill p-3" style="background-color: white; border-radius: 12px;">
            <div class="text-muted mb-1" style="font-size: 0.8rem;">Aujourd'hui</div>
            <div class="fw-bold" style="font-size: 1.8rem; color: #1A2018;">{{ $verificationsJour }}</div>
        </div>
        <div class="flex-fill p-3" style="background-color: white; border-radius: 12px;">
            <div class="text-muted mb-1" style="font-size: 0.8rem;">Refus</div>
            <div class="fw-bold" style="font-size: 1.8rem; color: #1A2018;">{{ $refusesJour }}</div>
        </div>
    </div>

    <div class="w-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0" style="color: #9CA3AF; font-weight: 500;">Dernières vérifications</h6>
            <a href="{{ route('verificateur.historique') }}" class="text-decoration-none" style="color: #D9C5B2; font-size: 0.85rem;">Tout voir</a>
        </div>

        <div class="d-flex flex-column gap-2">
            @forelse($dernieresVerifications as $verif)
                <div class="d-flex align-items-center justify-content-between p-3" style="background-color: white; border-radius: 12px;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #F3F4F6;">
                            <i class="bi bi-person-fill" style="color: #9CA3AF; font-size: 1.2rem;"></i>
                        </div>
                        <div>
                            <div style="color: #1A2018; font-weight: 600; font-size: 0.95rem;">
                                @if($verif->soldat)
                                    {{ $verif->soldat->nom }}
                                @else
                                    Visage inconnu
                                @endif
                            </div>
                            <div style="color: #6B7280; font-size: 0.75rem;">{{ $verif->created_at->format('H:i') }}</div>
                        </div>
                    </div>
                    
                    @if($verif->resultat === 'reconnu')
                        <span class="badge" style="background-color: #D1FAE5; color: #10B981; font-weight: 500; padding: 6px 12px; border-radius: 20px;"><i class="bi bi-check-circle"></i> Reconnu</span>
                    @else
                        <span class="badge" style="background-color: #FEE2E2; color: #EF4444; font-weight: 500; padding: 6px 12px; border-radius: 20px;"><i class="bi bi-x-circle"></i> Non reconnu</span>
                    @endif
                </div>
            @empty
                <div class="text-center p-4" style="background-color: white; border-radius: 12px; color: #6B7280;">
                    Aucune vérification récente.
                </div>
            @endforelse
        </div>
    </div>
@endsection