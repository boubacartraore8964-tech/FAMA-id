

<?php $__env->startSection('content'); ?>
    <div class="w-100" style="max-width: 400px;">
        <div class="d-flex align-items-center gap-2 mb-4 p-2 rounded" style="background-color: var(--fama-surface);">
            <i class="bi bi-journal-text text-warning"></i>
            <span class="fw-bold">Historique du poste</span>
        </div>

        <h6 class="text-muted mb-3" style="font-size: 0.8rem;">Aujourd'hui</h6>

        <div class="d-flex flex-column gap-2">
            <?php $__empty_1 = true; $__currentLoopData = $verifications ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $verif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background-color: var(--fama-surface);">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-person-circle fs-4 text-muted"></i>
                        <div>
                            <div style="font-size: 0.85rem;">
                                <?php if($verif->soldat): ?> <?php echo e($verif->soldat->nom); ?> <?php else: ?> Visage inconnu <?php endif; ?>
                            </div>
                            <div style="font-size: 0.7rem; color: var(--fama-muted);"><?php echo e($verif->created_at->format('H:i')); ?>, score 98 %</div>
                        </div>
                    </div>
                    <?php if($verif->resultat === 'reconnu'): ?>
                        <span class="badge" style="background-color: rgba(74, 222, 128, 0.2); color: var(--fama-green-light); font-weight: normal;">Reconnu</span>
                    <?php else: ?>
                        <span class="badge" style="background-color: rgba(239, 68, 68, 0.2); color: var(--fama-danger); font-weight: normal;">Non reconnu</span>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center text-muted p-4">
                    Aucune vérification récente.
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.mobile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\fama-id\resources\views/verificateur/historique.blade.php ENDPATH**/ ?>