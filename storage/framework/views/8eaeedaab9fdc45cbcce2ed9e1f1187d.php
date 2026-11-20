<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Réussie - FAMA ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F4F5F0; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .success-card { max-width: 500px; background: white; padding: 50px; border-radius: 16px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .icon-success { width: 80px; height: 80px; background: #D1FAE5; color: #10B981; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto; font-size: 2.5rem; }
    </style>
</head>
<body>

<div class="success-card">
    <div class="icon-success">
        <i class="bi bi-check-lg"></i>
    </div>
    <h3 class="fw-bold mb-3" style="color: #1A2018;">Dossier envoyé !</h3>
    <p class="text-muted mb-4">
        Félicitations <?php echo e(session('nom')); ?>, vos informations ont bien été transmises.
        <br><br>
        Votre profil est actuellement **en attente de validation** par l'administrateur de votre base. Vous ne pourrez pas encore passer les portes tant qu'il n'aura pas validé vos photos.
    </p>
    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-secondary w-100 py-2">Retour à la page de connexion</a>
</div>

</body>
</html><?php /**PATH C:\Users\USER\fama-id\resources\views/inscription_success.blade.php ENDPATH**/ ?>