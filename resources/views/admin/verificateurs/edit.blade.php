@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Modifier le Vérificateur</h1>
    <a href="{{ route('verificateurs.index') }}" class="btn btn-outline-secondary">Retour</a>
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

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('verificateurs.update', $verificateur->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nom complet de l'agent</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $verificateur->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Poste affecté</label>
                    <input type="text" name="poste" class="form-control" value="{{ old('poste', $verificateur->poste) }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Identifiant de connexion</label>
                    <input type="text" name="email" class="form-control" value="{{ old('email', $verificateur->email) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nouveau mot de passe (Laisser vide pour ne pas changer)</label>
                    <input type="password" name="password" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-fama">Mettre à jour le compte</button>
        </form>
    </div>
</div>
@endsection