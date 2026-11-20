

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Gestion des Vérificateurs</h1>
    <a href="<?php echo e(route('verificateurs.create')); ?>" class="btn btn-fama">
        <i class="bi bi-plus-lg"></i> Nouveau Vérificateur
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nom complet</th>
                        <th>Identifiant (Email)</th>
                        <th>Poste affecté</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $verificateurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $verif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($verif->name); ?></strong></td>
                            <td><?php echo e($verif->email); ?></td>
                            <td><span class="badge bg-secondary"><?php echo e($verif->poste); ?></span></td>
                            <td>
                                <?php if($verif->is_active): ?>
                                    <span class="badge bg-success">Actif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactif</span>
                                <?php endif; ?>
                            </td>
                            <td>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('verificateurs.edit', $verif->id)); ?>" class="btn btn-sm btn-outline-primary" title="Modifier">
            <i class="bi bi-pencil"></i>
        </a>
        <form action="<?php echo e(route('verificateurs.destroy', $verif->id)); ?>" method="POST" onsubmit="return confirm('Supprimer ce compte vérificateur ?');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
</td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Aucun vérificateur enregistré.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($verificateurs->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\fama-id\resources\views/admin/verificateurs/index.blade.php ENDPATH**/ ?>