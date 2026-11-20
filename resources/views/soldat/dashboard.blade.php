@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0">Guichet d'Enregistrement des Soldats</h4>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger">Déconnexion</button>
        </form>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3 shadow-sm p-4 border">
        <form action="{{ route('inscription.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Nom</label>
                    <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Prénom</label>
                    <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Matricule</label>
                    <input type="text" name="matricule" class="form-control" value="{{ old('matricule') }}" required placeholder="Ex: MAT-204871">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Numéro de téléphone</label>
                    <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}">
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-medium">Grade</label>
                    <input type="text" name="grade" class="form-control" list="list_grades" required>
                    <datalist id="list_grades">@foreach($grades as $g) <option value="{{ $g }}"> @endforeach</datalist>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-medium">Unité</label>
                    <input type="text" name="unite" class="form-control" list="list_unites" required>
                    <datalist id="list_unites">@foreach($unites as $u) <option value="{{ $u }}"> @endforeach</datalist>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-medium">Base d'affectation</label>
                    <input type="text" name="base_affectation" class="form-control" list="list_bases" required>
                    <datalist id="list_bases">@foreach($bases as $b) <option value="{{ $b }}"> @endforeach</datalist>
                </div>
            </div>

            <h5 class="fw-bold mb-3" style="color: #2F5233;"><i class="bi bi-camera"></i> Photos du visage</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-medium">Photo de Face (Obligatoire)</label>
                    <input type="file" name="photo" class="form-control" accept="image/*" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-medium">Profil Gauche</label>
                    <input type="file" name="photo_profil_gauche" class="form-control" accept="image/*">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-medium">Profil Droit</label>
                    <input type="file" name="photo_profil_droit" class="form-control" accept="image/*">
                </div>
            </div>

            <button type="submit" class="btn text-white px-4" style="background-color: var(--admin-green);">Envoyer le dossier</button>
        </form>
    </div>
@endsection