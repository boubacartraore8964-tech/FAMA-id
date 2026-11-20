@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center mb-4 gap-2">
        <a href="{{ route('soldats.index') }}" class="text-muted text-decoration-none"><i class="bi bi-chevron-left"></i></a>
        <h4 class="fw-bold m-0">Enregistrer un soldat</h4>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('soldats.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-md-7">
                <div class="bg-white rounded-3 shadow-sm p-4 border h-100">
                    <h6 class="fw-bold mb-4">Identité</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted" style="font-size: 0.85rem;">Nom</label>
                            <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted" style="font-size: 0.85rem;">Prénom</label>
                            <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted" style="font-size: 0.85rem;">Matricule</label>
                            <input type="text" name="matricule" class="form-control" value="{{ old('matricule') }}" required placeholder="Ex: MAT-204871">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted" style="font-size: 0.85rem;">Numéro de téléphone</label>
                            <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}">
                        </div>
                    </div>
                    <div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label text-muted" style="font-size: 0.85rem;">Grade</label>
        <input type="text" name="grade" class="form-control" value="{{ old('grade') }}" list="list_grades" required placeholder="Choisir ou taper">
        <datalist id="list_grades">
            @foreach($grades as $g)
                <option value="{{ $g }}">
            @endforeach
        </datalist>
    </div>
    <div class="col-md-4">
        <label class="form-label text-muted" style="font-size: 0.85rem;">Unité</label>
        <input type="text" name="unite" class="form-control" value="{{ old('unite') }}" list="list_unites" required placeholder="Choisir ou taper">
        <datalist id="list_unites">
            @foreach($unites as $u)
                <option value="{{ $u }}">
            @endforeach
        </datalist>
    </div>
    <div class="col-md-4">
        <label class="form-label text-muted" style="font-size: 0.85rem;">Base d'affectation</label>
        <input type="text" name="base_affectation" class="form-control" value="{{ old('base_affectation') }}" list="list_bases" required placeholder="Choisir ou taper">
        <datalist id="list_bases">
            @foreach($bases as $b)
                <option value="{{ $b }}">
            @endforeach
        </datalist>
    </div>
</div>
                    
                    <div class="mt-4 p-3 rounded" style="background-color: #F8FAFC; border: 1px dashed #CBD5E1; font-size: 0.8rem; color: #64748B;">
                        <i class="bi bi-info-circle"></i> L'identifiant unique est créé automatiquement à l'enregistrement.
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="bg-white rounded-3 shadow-sm p-4 border h-100">
                    <h6 class="fw-bold mb-4">Photos du visage</h6>
                    
                    <div class="mb-4">
                        <label class="form-label text-muted" style="font-size: 0.85rem;">Photo de Face (Obligatoire)</label>
                        <input type="file" name="photo" class="form-control" accept="image/*" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted" style="font-size: 0.85rem;">Profil Gauche (Optionnel)</label>
                        <input type="file" name="photo_profil_gauche" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted" style="font-size: 0.85rem;">Profil Droit (Optionnel)</label>
                        <input type="file" name="photo_profil_droit" class="form-control" accept="image/*">
                    </div>

                    <div class="text-muted" style="font-size: 0.75rem;">
                        <i class="bi bi-camera"></i> Les visages doivent être nets. L'IA vérifie la qualité à l'enregistrement.
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('soldats.index') }}" class="btn btn-light border px-4">Annuler</a>
            <button type="submit" class="btn text-white px-4" style="background-color: var(--admin-green);">Enregistrer le soldat</button>
        </div>
    </form>
@endsection