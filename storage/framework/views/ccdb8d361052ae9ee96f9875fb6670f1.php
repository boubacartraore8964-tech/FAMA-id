<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAMA ID - Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --admin-sidebar: #1A2018;
            --admin-bg: #F4F5F0;
            --admin-green: #2F5233;
            --admin-sable: #D9C5B2;
            --admin-text: #374151;
            --admin-border: #E5E7EB;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--admin-bg);
            color: var(--admin-text);
            margin: 0;
            overflow-x: hidden;
        }
        .sidebar {
            background-color: var(--admin-sidebar);
            color: white;
            min-height: 100vh;
            width: 260px;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }
        .sidebar-brand {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            text-decoration: none;
            color: white;
        }
        .sidebar-brand i {
            background-color: var(--admin-sable);
            color: var(--admin-sidebar);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        .sidebar-nav {
            padding: 20px 10px;
            flex: 1;
            overflow-y: auto;
        }
        .sidebar-nav a {
            color: #9CA3AF;
            text-decoration: none;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 5px;
            transition: 0.2s;
        }
        .sidebar-nav a:hover, .sidebar-nav a.active {
            background-color: rgba(255,255,255,0.05);
            color: white;
        }
        .sidebar-nav a i {
            font-size: 1.1rem;
        }
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .topbar {
            background-color: white;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            border-bottom: 1px solid var(--admin-border);
        }
        .search-bar {
            background-color: var(--admin-bg);
            border-radius: 8px;
            padding: 8px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 350px;
            border: 1px solid transparent;
        }
        .search-bar input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            font-size: 0.9rem;
        }
        .page-content {
            padding: 30px;
            flex: 1;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-brand">
            <i class="bi bi-shield-lock-fill"></i> FAMA ID
        </a>
        
        <div class="sidebar-nav">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <i class="bi bi-grid-1x2"></i> Tableau de bord
            </a>
            <a href="<?php echo e(route('soldats.index')); ?>" class="<?php echo e(request()->routeIs('soldats.*') ? 'active' : ''); ?>">
                <i class="bi bi-people"></i> Soldats
            </a>
            <a href="<?php echo e(route('verificateurs.index')); ?>" class="<?php echo e(request()->routeIs('verificateurs.*') ? 'active' : ''); ?>">
                <i class="bi bi-person-badge"></i> Vérificateurs
            </a>
            <a href="<?php echo e(route('historique.index')); ?>" class="<?php echo e(request()->routeIs('historique.*') ? 'active' : ''); ?>">
                <i class="bi bi-clock-history"></i> Historique
            </a>
           <?php
    $alertesActives = \App\Models\Alerte::where('statut', 'ouverte')->count();
?>
<a href="<?php echo e(route('alertes.index')); ?>" class="<?php echo e(request()->routeIs('alertes.*') ? 'active' : ''); ?>">
    <i class="bi bi-exclamation-triangle"></i> Alertes
    <?php if($alertesActives > 0): ?>
        <span class="badge bg-warning text-dark ms-auto rounded-pill"><?php echo e($alertesActives); ?></span>
    <?php endif; ?>
</a>
            <a href="<?php echo e(route('parametres.index')); ?>" class="<?php echo e(request()->routeIs('parametres.*') ? 'active' : ''); ?>">
                <i class="bi bi-gear"></i> Paramètres
            </a>
        </div>

        <div class="sidebar-footer">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 35px; height: 35px; background-color: var(--admin-green); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: white;">
                        A
                    </div>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600;"><?php echo e(Auth::user()->name ?? 'Admin'); ?></div>
                        <div style="font-size: 0.7rem; color: #9CA3AF;">Admin central</div>
                    </div>
                </div>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-sm text-danger p-0 border-0" title="Déconnexion"><i class="bi bi-box-arrow-right fs-5"></i></button>
                </form>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="topbar">
            <form action="<?php echo e(route('soldats.index')); ?>" method="GET" class="search-bar m-0">
                <i class="bi bi-search text-muted"></i>
                <input type="text" name="search" placeholder="Rechercher un nom, matricule, unité..." value="<?php echo e(request('search')); ?>">
            </form>
            <div class="d-flex align-items-center gap-3">
                <a href="<?php echo e(url()->current()); ?>" class="text-muted text-decoration-none" style="font-size: 0.85rem;">
                    <i class="bi bi-arrow-clockwise"></i> Actualiser
                </a>
            </div>
        </div>

        <div class="page-content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\Users\USER\fama-id\resources\views/layouts/app.blade.php ENDPATH**/ ?>