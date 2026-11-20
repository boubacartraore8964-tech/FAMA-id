

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0">Alertes</h4>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex gap-4 border-bottom mb-4">
        <a href="<?php echo e(route('alertes.index', ['statut' => 'ouverte'])); ?>" class="text-decoration-none fw-bold pb-2" style="<?php echo e($statut === 'ouverte' ? 'color: var(--admin-text); border-bottom: 2px solid var(--admin-green);' : 'color: #6B7280; border-bottom: 2px solid transparent;'); ?>">
            Ouvertes
        </a>
        <a href="<?php echo e(route('alertes.index', ['statut' => 'traitee'])); ?>" class="text-decoration-none fw-bold pb-2" style="<?php echo e($statut === 'traitee' ? 'color: var(--admin-text); border-bottom: 2px solid var(--admin-green);' : 'color: #6B7280; border-bottom: 2px solid transparent;'); ?>">
            Traitées
        </a>
    </div>

    <div class="row g-4">
        <!-- Liste des alertes (Gauche) -->
        <div class="col-md-5">
            <div class="d-flex flex-column gap-2">
                <?php $__empty_1 = true; $__currentLoopData = $alertes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alerte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('alertes.index', ['statut' => $statut, 'id' => $alerte->id])); ?>" class="text-decoration-none">
                        <!-- J'ai mis un fond légèrement rouge (#FEF2F2) pour les alertes ouvertes -->
                        <div class="p-3 rounded-3 border" style="background-color: <?php echo e($statut === 'ouverte' ? '#FEF2F2' : 'white'); ?>; border-color: <?php echo e($selectedAlerte && $selectedAlerte->id === $alerte->id ? '#EF4444' : 'var(--admin-border)'); ?> !important;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                                        <i class="bi bi-exclamation-triangle text-danger"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold" style="font-size: 0.9rem; color: var(--admin-text);"><?php echo e($alerte->message); ?></div>
                                        <div style="font-size: 0.75rem; color: #6B7280;"><?php echo e($alerte->verification->verificateur->name ?? 'Système'); ?> - <?php echo e($alerte->created_at->format('d/m/Y H:i')); ?></div>
                                    </div>
                                </div>
                                <?php if($alerte->statut === 'ouverte'): ?>
                                    <span class="badge bg-danger text-white badge-status">Non traitée</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-5 bg-white rounded-3 border">
                        <i class="bi bi-shield-check fs-1 d-block mb-2 text-success"></i>
                        Aucune alerte dans cette catégorie.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Détails de l'alerte (Droite) -->
        <div class="col-md-7">
            <?php if($selectedAlerte): ?>
                <div class="bg-white rounded-3 shadow-sm border p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <h6 class="fw-bold m-0">Détails de l'alerte</h6>
                        <?php if($selectedAlerte->statut === 'ouverte'): ?>
                            <span class="badge bg-danger text-white badge-status">Ouverte</span>
                        <?php else: ?>
                            <span class="badge bg-success text-white badge-status">Traitée</span>
                        <?php endif; ?>
                    </div>

                    <div class="row mb-4">
                        <div class="col-4 text-center">
                            <!-- Affichage de la photo avec vérification stricte -->
                            <?php if($selectedAlerte->verification && $selectedAlerte->verification->photo_scan_path && file_exists(storage_path('app/public/' . $selectedAlerte->verification->photo_scan_path))): ?>
                                <img src="<?php echo e(asset('storage/' . $selectedAlerte->verification->photo_scan_path)); ?>" class="img-fluid rounded" style="border: 2px solid #EF4444;">
                            <?php else: ?>
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <div class="text-center text-muted">
                                        <i class="bi bi-person-x fs-1 d-block"></i>
                                        <span style="font-size: 0.7rem;">Aucune photo</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="mt-2 text-muted fw-bold" style="font-size: 0.8rem;">Photo capturée</div>
                        </div>
                        <div class="col-8">
                            <table class="table table-sm table-borderless" style="font-size: 0.9rem;">
                                <tr>
                                    <td class="text-muted" style="width: 40%;">Poste</td>
                                    <td class="fw-medium"><?php echo e($selectedAlerte->verification->verificateur->poste ?? 'Non défini'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Vérificateur</td>
                                    <td class="fw-medium"><?php echo e($selectedAlerte->verification->verificateur->name ?? 'Inconnu'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Date et heure</td>
                                    <td class="fw-medium"><?php echo e($selectedAlerte->created_at->format('d/m/Y à H:i')); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Type</td>
                                    <td class="fw-medium"><span class="badge bg-warning text-dark"><?php echo e(ucfirst($selectedAlerte->type)); ?></span></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Contrôle du vivant</td>
                                    <td class="fw-medium text-success">Réussi</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-auto">
                        <form action="<?php echo e(route('alertes.traiter', $selectedAlerte->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn text-white px-4 py-2" style="background-color: var(--admin-green);" <?php echo e($selectedAlerte->statut === 'traitee' ? 'disabled' : ''); ?>>
                                Marquer comme traitée
                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-3 shadow-sm border p-5 h-100 d-flex flex-column align-items-center justify-content-center text-muted">
                    <i class="bi bi-envelope-open fs-1 mb-3"></i>
                    <h6>Sélectionnez une alerte</h6>
                    <p class="text-center mb-0" style="font-size: 0.85rem;">Cliquez sur une alerte à gauche pour voir les détails.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\fama-id\resources\views/admin/alertes.blade.php ENDPATH**/ ?>