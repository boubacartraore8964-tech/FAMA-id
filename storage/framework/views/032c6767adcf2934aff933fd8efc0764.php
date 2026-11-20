<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>FAMA ID - Vérificateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --fama-dark: #0B0F0C;
            --fama-surface: #151A16;
            --fama-green: #2F5233;
            --fama-green-light: #4ADE80;
            --fama-sable: #D9C5B2;
            --fama-danger: #EF4444;
            --fama-warning: #F59E0B;
            --fama-text: #F3F4F6;
            --fama-muted: #9CA3AF;
        }
        body {
            background-color: var(--fama-dark);
            color: var(--fama-text);
            font-family: 'Inter', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .top-bar {
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--fama-surface);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .content-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-y: auto;
        }
        .bottom-nav {
            background-color: var(--fama-surface);
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .bottom-nav a {
            color: var(--fama-muted);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 0.75rem;
            gap: 4px;
        }
        .bottom-nav a.active {
            color: var(--fama-green-light);
        }
        .bottom-nav i {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

    <div class="top-bar">
        <div class="d-flex align-items-center gap-2">
            <div style="background-color: var(--fama-sable); color: var(--fama-dark); padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <span class="fw-bold" style="font-size: 0.9rem;">FAMA ID</span>
        </div>
        <div>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="content-area">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <div class="bottom-nav">
        <a href="<?php echo e(route('verificateur.dashboard')); ?>" class="<?php echo e(request()->routeIs('verificateur.dashboard') ? 'active' : ''); ?>">
            <i class="bi bi-grid"></i> Accueil
        </a>
        <a href="<?php echo e(route('verificateur.historique') ?? '#'); ?>" class="<?php echo e(request()->routeIs('verificateur.historique') ? 'active' : ''); ?>">
            <i class="bi bi-journal-text"></i> Historique
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\Users\USER\fama-id\resources\views/layouts/mobile.blade.php ENDPATH**/ ?>