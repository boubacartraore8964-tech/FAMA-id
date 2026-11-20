<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - FAMA ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --fama-dark: #1A2018;
            --fama-green: #2F5233;
            --fama-sable: #D9C5B2;
            --fama-bg: #F4F5F0;
        }
        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            margin: 0;
            background-color: var(--fama-bg);
        }
        .split-screen {
            display: flex;
            height: 100vh;
        }
        .left-panel {
            background-color: var(--fama-dark);
            color: white;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }
        .brand-logo {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .brand-logo i {
            background-color: var(--fama-sable);
            color: var(--fama-dark);
            padding: 5px 8px;
            border-radius: 6px;
            font-size: 1.2rem;
        }
        .slogan {
            font-size: 2.5rem;
            font-weight: 600;
            line-height: 1.2;
            margin-bottom: 2rem;
        }
        .image-container {
            width: 100%;
            margin-top: auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.6);
        }
        .soldiers-img {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
            display: block;
        }
        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background-color: var(--fama-bg);
        }
        .login-box {
            width: 100%;
            max-width: 400px;
        }
        .login-title {
            font-size: 2rem;
            font-weight: 600;
            color: var(--fama-dark);
            margin-bottom: 2rem;
        }
        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #4b5563;
        }
        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: #9ca3af;
        }
        .form-control {
            border-left: none;
            background-color: white;
            padding: 0.75rem;
            box-shadow: none !important;
        }
        .input-group:focus-within {
            border-color: var(--fama-green);
            box-shadow: 0 0 0 0.2rem rgba(47, 82, 51, 0.1);
            border-radius: 0.375rem;
        }
        .btn-fama {
            background-color: var(--fama-green);
            color: white;
            padding: 0.8rem;
            font-weight: 600;
            border-radius: 6px;
            border: none;
            transition: 0.3s;
        }
        .btn-fama:hover {
            background-color: #233d26;
            color: white;
        }
        .helper-text {
            font-size: 0.75rem;
            color: #6b7280;
            text-align: center;
            margin-top: 1.5rem;
        }
        @media (max-width: 992px) {
            .split-screen {
                flex-direction: column;
            }
            .left-panel {
                padding: 2rem;
                min-height: 300px;
            }
            .slogan {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

<div class="split-screen">
    <!-- Panneau Gauche (Image et Slogan) -->
    <div class="left-panel">
        <div class="brand-logo">
            <i class="bi bi-shield-check"></i> FAMA ID
        </div>
        
        <div>
            <div class="slogan">Le bon visage.<br>À la bonne porte.</div>
            <div class="image-container">
                <img src="<?php echo e(asset('images/soldats.jpg')); ?>" alt="Soldats" class="soldiers-img">
            </div>
        </div>
    </div>

    <!-- Panneau Droit (Connexion) -->
    <div class="right-panel">
        <div class="login-box">
            <h2 class="login-title">Connexion</h2>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger py-2" style="font-size: 0.85rem;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div><?php echo e($error); ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login.post')); ?>">
                <?php echo csrf_field(); ?>
                
                <div class="mb-3">
                    <label class="form-label">Identifiant</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <!-- J'ai enlevé le placeholder "verif.nord" -->
                        <input type="text" name="identifiant" class="form-control" required autofocus value="<?php echo e(old('identifiant')); ?>">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        <span class="input-group-text" style="border-left: none; cursor: pointer;" onclick="togglePassword(this)">
                            <i class="bi bi-eye-slash"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-fama w-100">Se connecter</button>
            </form>

            <div class="helper-text">
                <i class="bi bi-info-circle"></i> Identifiants fournis par votre administrateur
            </div>
            
            <!-- Lien pour les soldats (Optionnel) -->
            <div class="text-center mt-3">
                <a href="<?php echo e(route('login')); ?>" class="text-decoration-none" style="font-size: 0.8rem; color: var(--fama-green);">
                    Accès réservé au guichet d'inscription
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(element) {
        const input = element.previousElementSibling;
        const icon = element.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\Users\USER\fama-id\resources\views/auth/login.blade.php ENDPATH**/ ?>