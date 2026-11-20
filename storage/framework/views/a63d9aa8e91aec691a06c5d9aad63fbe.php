

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0">Historique des vérifications</h4>
        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-download"></i> Exporter</button>
    </div>

   <form action="<?php echo e(route('historique.index')); ?>" method="GET" class="d-flex justify-content-between mb-3">
    <div class="d-flex gap-2">
        <select name="poste" class="form-select form-select-sm" style="width: 180px; border-radius: 6px;" onchange="this.form.submit()">
            <option value="">Tous les postes</option>
            <?php $__currentLoopData = $postes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($p); ?>" <?php echo e(request('poste') == $p ? 'selected' : ''); ?>><?php echo e($p); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select name="resultat" class="form-select form-select-sm" style="width: 180px; border-radius: 6px;" onchange="this.form.submit()">
            <option value="">Tous les résultats</option>
            <option value="reconnu" <?php echo e(request('resultat') === 'reconnu' ? 'selected' : ''); ?>>Reconnu</option>
            <option value="non_reconnu" <?php echo e(request('resultat') === 'non_reconnu' ? 'selected' : ''); ?>>Non reconnu</option>
            <option value="fraude" <?php echo e(request('resultat') === 'fraude' ? 'selected' : ''); ?>>Fraude</option>
            <option value="suspendu" <?php echo e(request('resultat') === 'suspendu' ? 'selected' : ''); ?>>Suspendu</option>
        </select>

        <select name="date" class="form-select form-select-sm" style="width: 150px; border-radius: 6px;" onchange="this.form.submit()">
            <option value="">Toutes les dates</option>
            <option value="today" <?php echo e(request('date') === 'today' ? 'selected' : ''); ?>>Aujourd'hui</option>
        </select>
    </div>
</form>

    <div class="bg-white rounded-3 shadow-sm border" style="border-color: var(--admin-border) !important;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 text-muted fw-normal" style="font-size: 0.85rem; padding: 15px 20px;">Date et heure</th>
                        <th class="border-0 text-muted fw-normal" style="font-size: 0.85rem;">Poste</th>
                        <th class="border-0 text-muted fw-normal" style="font-size: 0.85rem;">Vérificateur</th>
                        <th class="border-0 text-muted fw-normal" style="font-size: 0.85rem;">Personne</th>
                        <th class="border-0 text-muted fw-normal" style="font-size: 0.85rem;">Score</th>
                        <th class="border-0 text-muted fw-normal" style="font-size: 0.85rem; text-align: right; padding-right: 20px;">Résultat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $verifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $verif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td style="padding: 15px 20px; font-size: 0.9rem;">
                                <?php echo e(\Carbon\Carbon::parse($verif->date_heure)->format('d/m/Y, H:i')); ?>

                            </td>
                            <td style="font-size: 0.9rem;"><?php echo e($verif->verificateur->poste ?? 'N/A'); ?></td>
                            <td style="font-size: 0.9rem;"><?php echo e($verif->verificateur->name ?? 'Système'); ?></td>
                            <td style="font-size: 0.9rem;">
                                <?php if($verif->soldat): ?>
                                    <?php echo e($verif->soldat->nom); ?> <?php echo e($verif->soldat->prenom); ?>

                                <?php else: ?>
                                    <span class="text-muted">Visage inconnu</span>
                                <?php endif; ?>
                            </td>
                            <td style="font-size: 0.9rem;">-- %</td>
                            <td style="text-align: right; padding-right: 20px;">
                                <?php if($verif->resultat === 'reconnu'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success badge-status">Reconnu</span>
                                <?php elseif($verif->resultat === 'non_reconnu'): ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger badge-status">Non reconnu</span>
                                <?php else: ?>
                                    <span class="badge bg-dark bg-opacity-10 text-dark badge-status">Fraude</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">Aucune vérification trouvée pour ces critères.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top">
            <?php echo e($verifications->appends(request()->query())->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\fama-id\resources\views/admin/historique.blade.php ENDPATH**/ ?>