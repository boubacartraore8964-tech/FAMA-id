<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Inscription - FAMA ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #1A2018; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card-acces { max-width: 400px; width: 100%; background: white; padding: 40px; border-radius: 16px; text-align: center; }
    </style>
</head>
<body>
    <div class="card-acces">
        <h3 class="fw-bold mb-3" style="color: #2F5233;">Guichet d'Inscription</h3>
        <p class="text-muted mb-4" style="font-size: 0.9rem;">Veuillez saisir le code d'accès fourni par votre commandement pour vous enregistrer.</p>
        
        @if ($errors->any())
            <div class="alert alert-danger py-2" style="font-size: 0.85rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('inscription.check') }}" method="POST">
            @csrf
            <div class="mb-4">
                <input type="password" name="code_acces" class="form-control form-control-lg text-center" placeholder="Code d'accès" required style="letter-spacing: 2px; font-weight: bold;">
            </div>
            <button type="submit" class="btn w-100 py-2 text-white" style="background-color: #2F5233; font-weight: 600;">Accéder au formulaire</button>
        </form>
    </div>
</body>
</html>