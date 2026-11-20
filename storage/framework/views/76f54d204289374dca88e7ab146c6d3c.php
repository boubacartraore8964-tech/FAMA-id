

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-2">
            <a href="<?php echo e(route('soldats.index')); ?>" class="text-muted text-decoration-none">Soldats</a>
            <span class="text-muted">/</span>
            <span class="fw-bold" style="color: var(--admin-text);"><?php echo e($soldat->nom); ?> <?php echo e($soldat->prenom); ?></span>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('soldats.edit', $soldat->id)); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Modifier</a>
            <form action="<?php echo e(route('soldats.toggle', $soldat->id)); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <button type="submit" class="btn btn-sm btn-outline-warning">
                    <i class="bi bi-pause"></i> <?php echo e($soldat->statut === 'actif' ? 'Suspendre' : 'Réactiver'); ?>

                </button>
            </form>
            <form action="<?php echo e(route('soldats.destroy', $soldat->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce soldat ?');">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Supprimer</button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <!-- Colonne Info -->
        <div class="col-md-8">
            <div class="bg-white rounded-3 shadow-sm border p-4 h-100">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <img src="<?php echo e(asset('storage/' . $soldat->photo_path)); ?>" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                    <div>
                        <h4 class="fw-bold m-0"><?php echo e($soldat->nom); ?> <?php echo e($soldat->prenom); ?></h4>
                        <div class="text-muted"><?php echo e($soldat->grade); ?>, <?php echo e($soldat->unite); ?></div>
                    </div>
                    <div class="ms-auto">
                        <?php if($soldat->statut === 'actif'): ?>
                            <span class="badge bg-success bg-opacity-10 text-success" style="font-size: 0.9rem;">Actif</span>
                        <?php else: ?>
                            <span class="badge bg-warning bg-opacity-10 text-warning" style="font-size: 0.9rem;">Suspendu</span>
                        <?php endif; ?>
                    </div>
                </div>

                <h6 class="fw-bold mb-3 mt-5">Identité</h6>
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted" style="width: 30%;">Matricule</td>
                        <td class="fw-medium"><?php echo e($soldat->matricule); ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Numéro</td>
                        <td class="fw-medium"><?php echo e($soldat->telephone ?? 'Non renseigné'); ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Grade</td>
                        <td class="fw-medium"><?php echo e($soldat->grade); ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Unité</td>
                        <td class="fw-medium"><?php echo e($soldat->unite); ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Base d'affectation</td>
                        <td class="fw-medium"><?php echo e($soldat->base_affectation); ?></td>
                    </tr>
                </table>

                <h6 class="fw-bold mb-3 mt-4">Photos enregistrées</h6>
                <div class="d-flex gap-3">
                    <div class="text-center">
                        <img src="<?php echo e(asset('storage/' . $soldat->photo_path)); ?>" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="text-muted mt-1" style="font-size: 0.75rem;">Face</div>
                    </div>
                    <?php if($soldat->photo_profil_gauche): ?>
                    <div class="text-center">
                        <img src="<?php echo e(asset('storage/' . $soldat->photo_profil_gauche)); ?>" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="text-muted mt-1" style="font-size: 0.75rem;">Profil G.</div>
                    </div>
                    <?php endif; ?>
                    <?php if($soldat->photo_profil_droit): ?>
                    <div class="text-center">
                        <img src="<?php echo e(asset('storage/' . $soldat->photo_profil_droit)); ?>" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="text-muted mt-1" style="font-size: 0.75rem;">Profil D.</div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Colonne Historique (Dynamique) -->
        <div class="col-md-4">
            <div class="bg-white rounded-3 shadow-sm border p-4 h-100">
                <h6 class="fw-bold mb-3">Dernières vérifications</h6>
                <?php $__empty_1 = true; $__currentLoopData = $soldat->verifications()->latest()->take(4)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $verif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="fw-medium" style="font-size: 0.85rem;"><?php echo e($verif->verificateur->poste ?? 'Poste inconnu'); ?></div>
                            <div class="text-muted" style="font-size: 0.75rem;"><?php echo e($verif->created_at->format('d/m/Y H:i')); ?></div>
                        </div>
                        <?php if($verif->resultat === 'reconnu'): ?>
                            <span class="badge bg-success bg-opacity-10 text-success">Reconnu</span>
                        <?php else: ?>
                            <span class="badge bg-danger bg-opacity-10 text-danger">Refusé</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-muted text-center py-4" style="font-size: 0.85rem;">Aucune vérification.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\fama-id\resources\views/admin/soldats/show.blade.php ENDPATH**/ ?>