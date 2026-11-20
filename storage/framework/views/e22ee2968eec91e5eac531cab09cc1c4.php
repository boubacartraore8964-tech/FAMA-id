

<?php $__env->startSection('content'); ?>
    <?php
        // Calcul du score en pourcentage (ex: si distance = 0.1, score = 90%)
        $score = isset($distance) ? round((1 - $distance) * 100) : 99;
        
        $bgClass = '';
        $icon = '';
        $title = '';
        $subtitle = '';
        
        if($verification->resultat === 'reconnu') {
            $bgClass = 'background-color: #198754; color: white;';
            $icon = 'bi-check-lg';
            $title = 'Soldat reconnu';
            $subtitle = 'Correspondance ' . $score . ' %. Personne réelle confirmée.';
        } elseif($verification->resultat === 'non_reconnu') {
            $bgClass = 'background-color: #EF4444; color: white;';
            $icon = 'bi-x-lg';
            $title = 'Non reconnu';
            $subtitle = 'Entrée refusée. Infiltré possible.';
        } elseif($verification->resultat === 'fraude') {
            $bgClass = 'background-color: #1A2018; color: white;';
            $icon = 'bi-shield-x';
            $title = 'Fraude détectée';
            $subtitle = 'Ce n\'est pas un visage réel.';
        } elseif($verification->resultat === 'suspendu') {
            $bgClass = 'background-color: #D97706; color: white;';
            $icon = 'bi-pause-circle';
            $title = 'Soldat suspendu';
            $subtitle = 'Identité reconnue, entrée non autorisée.';
        }
    ?>

    <div class="w-100" style="max-width: 380px;">
        
        <!-- En-tête -->
        <div class="p-4 mb-4" style="border-radius: 12px; <?php echo e($bgClass); ?>">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: rgba(255,255,255,0.2);">
                    <i class="bi <?php echo e($icon); ?> fs-4"></i>
                </div>
                <h4 class="m-0 fw-bold"><?php echo e($title); ?></h4>
            </div>
            <p class="mb-0" style="font-size: 0.85rem; opacity: 0.9;"><?php echo e($subtitle); ?></p>
        </div>

        <!-- Photos et Infos (Succès) -->
        <?php if($verification->resultat === 'reconnu' && $verification->soldat): ?>
            <div class="d-flex justify-content-center gap-4 mb-4">
                <div class="text-center">
                    <div style="width: 100px; height: 100px; background-color: #E5E7EB; border-radius: 8px; overflow: hidden;">
                        <img src="<?php echo e(asset('storage/' . $verification->soldat->photo_path)); ?>" alt="Enregistrée" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="text-white mt-2" style="font-size: 0.75rem;">Photo enregistrée</div>
                </div>
                <?php if($verification->photo_scan_path): ?>
                <div class="text-center">
                    <div style="width: 100px; height: 100px; background-color: #E5E7EB; border-radius: 8px; overflow: hidden;">
                        <img src="<?php echo e(asset('storage/' . $verification->photo_scan_path)); ?>" alt="Prise" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="text-white mt-2" style="font-size: 0.75rem;">Photo prise</div>
                </div>
                <?php endif; ?>
            </div>

            <div class="p-3 rounded mb-4" style="background-color: #151A16; color: white; border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex justify-content-between mb-2" style="font-size: 0.9rem;">
                    <span style="color: #9CA3AF;">Nom</span>
                    <span class="fw-medium"><?php echo e($verification->soldat->nom); ?> <?php echo e($verification->soldat->prenom); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size: 0.9rem;">
                    <span style="color: #9CA3AF;">Numéro</span>
                    <span class="fw-medium"><?php echo e($verification->soldat->telephone ?? 'Non renseigné'); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size: 0.9rem;">
                    <span style="color: #9CA3AF;">Matricule</span>
                    <span class="fw-medium"><?php echo e($verification->soldat->matricule); ?></span>
                </div>
                <div class="d-flex justify-content-between" style="font-size: 0.9rem;">
                    <span style="color: #9CA3AF;">Unité</span>
                    <span class="fw-medium"><?php echo e($verification->soldat->unite); ?></span>
                </div>
            </div>

        <!-- Infos (Non reconnu) -->
        <?php elseif($verification->resultat === 'non_reconnu'): ?>
            <div class="p-3 rounded mb-4 text-center" style="background-color: #EF4444; color: white;">
                <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                    <i class="bi bi-person-x fs-4"></i>
                    <div class="text-start">
                        <div class="fw-bold" style="font-size: 0.9rem;">Visage absent de la base</div>
                        <div style="font-size: 0.75rem;">Meilleure correspondance : <?php echo e($score); ?> %</div>
                    </div>
                </div>
            </div>
            <div class="text-white text-center mb-4" style="font-size: 0.85rem;">
                <i class="bi bi-bell-fill"></i> Alerte envoyée au tableau de bord<br>
                <span class="text-muted" style="font-size: 0.75rem;">Une mauvaise photo peut causer ce résultat. Refaites la prise.</span>
            </div>

        <!-- Infos (Fraude) -->
        <?php elseif($verification->resultat === 'fraude'): ?>
            <div class="p-3 rounded mb-4" style="background-color: #1A2018; color: white; border: 1px solid #EF4444;">
                <div class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-exclamation-octagon text-danger"></i> <span style="font-size: 0.9rem;">Photo d'écran</span></div>
                <div class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-exclamation-octagon text-danger"></i> <span style="font-size: 0.9rem;">Photo imprimée</span></div>
                <div class="d-flex align-items-center gap-2"><i class="bi bi-exclamation-octagon text-danger"></i> <span style="font-size: 0.9rem;">Masque</span></div>
            </div>
            <div class="text-white text-center mb-4" style="font-size: 0.85rem;">
                <i class="bi bi-bell-fill"></i> Alerte envoyée au tableau de bord
            </div>

        <!-- Infos (Suspendu) -->
        <?php elseif($verification->resultat === 'suspendu' && $verification->soldat): ?>
            <div class="p-3 rounded mb-4 d-flex align-items-center gap-3" style="background-color: #151A16; color: white; border: 1px solid rgba(255,255,255,0.05);">
                <div style="width: 60px; height: 60px; background-color: #E5E7EB; border-radius: 8px; overflow: hidden;">
                    <img src="<?php echo e(asset('storage/' . $verification->soldat->photo_path)); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div>
                    <div class="fw-bold" style="font-size: 0.95rem;"><?php echo e($verification->soldat->nom); ?></div>
                    <div style="font-size: 0.8rem; color: #9CA3AF;"><?php echo e($verification->soldat->matricule); ?></div>
                    <div style="font-size: 0.8rem; color: #9CA3AF;"><?php echo e($verification->soldat->grade); ?>, <?php echo e($verification->soldat->unite); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <!-- BOUTONS D'ACTION -->
        <div class="d-flex flex-column gap-2">
            <?php if($verification->resultat === 'reconnu'): ?>
                <a href="<?php echo e(route('verificateur.dashboard')); ?>" class="btn py-2 fw-bold" style="background-color: #2F5233; color: white; border-radius: 8px;">
                    <i class="bi bi-house"></i> Nouvelle vérification
                </a>
            <?php elseif($verification->resultat === 'non_reconnu' || $verification->resultat === 'fraude'): ?>
                <!-- Bouton double action : Appel + Notification -->
                <button onclick="appelerChef(<?php echo e($verification->id); ?>)" class="btn py-2 fw-bold" style="background-color: #F4F5F0; color: #1A2018; border-radius: 8px;">
                    <i class="bi bi-telephone"></i> Appeler le chef de poste
                </button>
                <a href="<?php echo e(route('verificateur.camera')); ?>" class="btn py-2" style="background-color: transparent; color: #EF4444; border: 1px solid #EF4444; border-radius: 8px;">
                    <i class="bi bi-camera"></i> Refaire la photo
                </a>
            <?php elseif($verification->resultat === 'suspendu'): ?>
                <button onclick="appelerChef(<?php echo e($verification->id); ?>)" class="btn py-2 fw-bold" style="background-color: #2F5233; color: white; border-radius: 8px;">
                    <i class="bi bi-telephone"></i> Appeler le chef de poste
                </button>
                <a href="<?php echo e(route('verificateur.dashboard')); ?>" class="btn py-2" style="background-color: transparent; color: #9CA3AF; border: 1px solid #9CA3AF; border-radius: 8px;">
                    Nouvelle vérification
                </a>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function appelerChef(verificationId) {
            // 1. On lance l'appel téléphonique (Remplace le numéro par celui du chef de poste)
            window.location.href = "tel:+22370000000"; 
            
            // 2. On envoie la notification à l'admin en arrière-plan (sans recharger la page)
            fetch(`/verificateur/appel-chef/${verificationId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    console.log("L'admin a été notifié.");
                }
            })
            .catch(error => console.error("Erreur de notification", error));
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.mobile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\fama-id\resources\views/verificateur/result.blade.php ENDPATH**/ ?>