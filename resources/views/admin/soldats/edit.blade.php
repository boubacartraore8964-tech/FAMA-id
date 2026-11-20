@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center mb-4 gap-2">
        <a href="{{ route('soldats.index') }}" class="text-muted text-decoration-none">Retour</a>
        <h4 class="fw-bold m-0">Modifier : {{ $soldat->nom }} {{ $soldat->prenom }}</h4>
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

    <form action="{{ route('soldats.update', $soldat->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-md-7">
                <div class="bg-white rounded-3 shadow-sm p-4 border">
                    <h6 class="fw-bold mb-4">Identité</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Nom</label>
                            <input type="text" name="nom" class="form-control" value="{{ $soldat->nom }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Prénom</label>
                            <input type="text" name="prenom" class="form-control" value="{{ $soldat->prenom }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Matricule</label>
                            <input type="text" name="matricule" class="form-control" value="{{ $soldat->matricule }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Téléphone</label>
                            <input type="text" name="telephone" class="form-control" value="{{ $soldat->telephone }}">
                        </div>
                    </div>

                    <div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label text-muted" style="font-size: 0.85rem;">Grade</label>
        <input type="text" name="grade" class="form-control" value="{{ old('grade', $soldat->grade) }}" list="list_grades" required>
        <datalist id="list_grades">
            @foreach($grades as $g)
                <option value="{{ $g }}">
            @endforeach
        </datalist>
    </div>
    <div class="col-md-4">
        <label class="form-label text-muted" style="font-size: 0.85rem;">Unité</label>
        <input type="text" name="unite" class="form-control" value="{{ old('unite', $soldat->unite) }}" list="list_unites" required>
        <datalist id="list_unites">
            @foreach($unites as $u)
                <option value="{{ $u }}">
            @endforeach
        </datalist>
    </div>
    <div class="col-md-4">
        <label class="form-label text-muted" style="font-size: 0.85rem;">Base d'affectation</label>
        <input type="text" name="base_affectation" class="form-control" value="{{ old('base_affectation', $soldat->base_affectation) }}" list="list_bases" required>
        <datalist id="list_bases">
            @foreach($bases as $b)
                <option value="{{ $b }}">
            @endforeach
        </datalist>
    </div>
</div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="bg-white rounded-3 shadow-sm p-4 border">
                    <h6 class="fw-bold mb-4">Photos (Vide = garder l'actuelle)</h6>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Photo de Face</label>
                        <input type="file" name="photo" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Profil Gauche</label>
                        <input type="file" name="photo_profil_gauche" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Profil Droit</label>
                        <input type="file" name="photo_profil_droit" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('soldats.index') }}" class="btn btn-light border px-4">Annuler</a>
            <button type="submit" class="btn text-white px-4" style="background-color: var(--admin-green);">Mettre à jour</button>
        </div>
    </form>
@endsection