<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Soldat - FAMA ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F4F5F0; padding: 40px 20px; }
        .form-container { max-width: 800px; margin: 0 auto; background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 40px; }
        .brand { text-align: center; margin-bottom: 30px; }
        .brand i { color: #2F5233; font-size: 2.5rem; }
        .brand h2 { color: #1A2018; font-weight: 700; margin-top: 10px; }
        .btn-fama { background-color: #2F5233; color: white; font-weight: 600; }
        .btn-fama:hover { background-color: #233d26; color: white; }
    </style>
</head>
<body>

<div class="form-container">
    <div class="brand">
        <i class="bi bi-shield-plus"></i>
        <h2>Enregistrement d'un Soldat</h2>
        <p class="text-muted">Veuillez remplir vos informations pour votre enregistrement dans la base FAMA ID.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

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
                <input type="text" name="grade" class="form-control" value="{{ old('grade') }}" list="list_grades" required placeholder="Choisir ou taper">
                <datalist id="list_grades">
                    @foreach($grades as $g) <option value="{{ $g }}"> @endforeach
                </datalist>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-medium">Unité</label>
                <input type="text" name="unite" class="form-control" value="{{ old('unite') }}" list="list_unites" required placeholder="Choisir ou taper">
                <datalist id="list_unites">
                    @foreach($unites as $u) <option value="{{ $u }}"> @endforeach
                </datalist>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-medium">Base d'affectation</label>
                <input type="text" name="base_affectation" class="form-control" value="{{ old('base_affectation') }}" list="list_bases" required placeholder="Choisir ou taper">
                <datalist id="list_bases">
                    @foreach($bases as $b) <option value="{{ $b }}"> @endforeach
                </datalist>
            </div>
        </div>

        <h5 class="fw-bold mb-3 mt-4" style="color: #2F5233;"><i class="bi bi-camera"></i> Photos du visage</h5>
        <p class="text-muted" style="font-size: 0.85rem;">L'IA vérifie la qualité de la photo. Assurez-vous d'être bien éclairé et de face.</p>

        <div class="row mb-4">
            <div class="col-md-4">
                <label class="form-label fw-medium">Photo de Face (Obligatoire)</label>
                <input type="file" name="photo" class="form-control" accept="image/*" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-medium">Profil Gauche (Optionnel)</label>
                <input type="file" name="photo_profil_gauche" class="form-control" accept="image/*">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-medium">Profil Droit (Optionnel)</label>
                <input type="file" name="photo_profil_droit" class="form-control" accept="image/*">
            </div>
        </div>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-fama btn-lg">Envoyer mon dossier d'inscription</button>
        </div>
        <div class="text-center mt-4 pt-3 border-top">
    <a href="{{ route('inscription.create') }}" class="text-decoration-none fw-medium" style="font-size: 0.85rem; color: var(--fama-green);">
        Nouveau soldat ? S'inscrire ici
    </a>
</div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>