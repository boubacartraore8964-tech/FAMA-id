

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0">Guichet d'Enregistrement des Soldats</h4>
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-sm btn-outline-danger">Déconnexion</button>
        </form>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($error); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-3 shadow-sm p-4 border">
        <form action="<?php echo e(route('inscription.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Nom</label>
                    <input type="text" name="nom" class="form-control" value="<?php echo e(old('nom')); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Prénom</label>
                    <input type="text" name="prenom" class="form-control" value="<?php echo e(old('prenom')); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Matricule</label>
                    <input type="text" name="matricule" class="form-control" value="<?php echo e(old('matricule')); ?>" required placeholder="Ex: MAT-204871">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Numéro de téléphone</label>
                    <input type="text" name="telephone" class="form-control" value="<?php echo e(old('telephone')); ?>">
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-medium">Grade</label>
                    <input type="text" name="grade" class="form-control" list="list_grades" required>
                    <datalist id="list_grades"><?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($g); ?>"> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></datalist>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-medium">Unité</label>
                    <input type="text" name="unite" class="form-control" list="list_unites" required>
                    <datalist id="list_unites"><?php $__currentLoopData = $unites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($u); ?>"> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></datalist>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-medium">Base d'affectation</label>
                    <input type="text" name="base_affectation" class="form-control" list="list_bases" required>
                    <datalist id="list_bases"><?php $__currentLoopData = $bases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($b); ?>"> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></datalist>
                </div>
            </div>

            <h5 class="fw-bold mb-3" style="color: #2F5233;"><i class="bi bi-camera"></i> Photos du visage</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-medium">Photo de Face (Obligatoire)</label>
                    <input type="file" name="photo" class="form-control" accept="image/*" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-medium">Profil Gauche</label>
                    <input type="file" name="photo_profil_gauche" class="form-control" accept="image/*">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-medium">Profil Droit</label>
                    <input type="file" name="photo_profil_droit" class="form-control" accept="image/*">
                </div>
            </div>

            <button type="submit" class="btn text-white px-4" style="background-color: var(--admin-green);">Envoyer le dossier</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\fama-id\resources\views/soldat/dashboard.blade.php ENDPATH**/ ?>