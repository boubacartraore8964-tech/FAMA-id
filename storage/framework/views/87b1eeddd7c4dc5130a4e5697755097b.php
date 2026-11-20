

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0">Tableau de bord</h4>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="p-3 bg-white rounded-3 shadow-sm border">
                <div class="text-muted mb-2" style="font-size: 0.85rem;">Vérifications (Aujourd'hui)</div>
                <h3 class="fw-bold mb-1"><?php echo e($verificationsJour); ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 bg-white rounded-3 shadow-sm border">
                <div class="text-muted mb-2" style="font-size: 0.85rem;">Soldats enregistrés</div>
                <h3 class="fw-bold mb-1"><?php echo e($totalSoldats); ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 bg-white rounded-3 shadow-sm border">
                <div class="text-muted mb-2" style="font-size: 0.85rem;">Alertes Actives</div>
                <h3 class="fw-bold mb-1 text-danger"><?php echo e($alertesOuvertes); ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 bg-white rounded-3 shadow-sm border">
                <div class="text-muted mb-2" style="font-size: 0.85rem;">Temps de réponse</div>
                <h3 class="fw-bold mb-1">~ 2 s</h3>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-7">
            <div class="bg-white rounded-3 shadow-sm p-4 border h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold m-0">Alertes à traiter</h6>
                    <a href="<?php echo e(route('alertes.index')); ?>" class="text-decoration-none" style="font-size: 0.85rem; color: var(--admin-green);">Voir toutes les alertes</a>
                </div>
                
                <?php $__empty_1 = true; $__currentLoopData = $dernieresAlertes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alerte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-exclamation-triangle text-danger"></i>
                            </div>
                            <div>
                                <div style="font-size: 0.9rem; font-weight: 500;"><?php echo e($alerte->verification->soldat ? $alerte->verification->soldat->nom : 'Visage inconnu'); ?></div>
                                <div style="font-size: 0.75rem; color: #6B7280;"><?php echo e($alerte->message); ?></div>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-danger bg-opacity-10 text-danger" style="padding: 5px 10px; border-radius: 6px;">Ouverte</span>
                            <div style="font-size: 0.7rem; color: #9CA3AF; margin-top: 4px;"><?php echo e($alerte->created_at->diffForHumans()); ?></div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-4">Aucune alerte active.</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-5">
            <div class="bg-white rounded-3 shadow-sm p-4 h-100 border">
                <h6 class="fw-bold mb-3">Postes de contrôle</h6>
                <?php
                    $postes = \App\Models\User::where('role', 'verificateur')->get();
                ?>
                <?php $__empty_1 = true; $__currentLoopData = $postes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $poste): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-success" style="width: 8px; height: 8px;"></div>
                            <span style="font-size: 0.85rem;"><?php echo e($poste->poste ?? 'Poste sans nom'); ?></span>
                        </div>
                        <span class="text-success" style="font-size: 0.8rem;">En ligne</span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-4">Aucun poste configuré.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="bg-white rounded-3 shadow-sm p-4 border">
                <h6 class="fw-bold mb-3">Vérifications par heure (Aujourd'hui)</h6>
                <canvas id="verificationsChart" height="80"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // On récupère les données PHP proprement
    const chartLabels = <?php echo json_encode($chartLabels, 15, 512) ?>;
    const chartData = <?php echo json_encode($chartData, 15, 512) ?>;

    // On dessine le graphique
    const ctx = document.getElementById('verificationsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Vérifications',
                data: chartData,
                backgroundColor: '#2F5233',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\fama-id\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>