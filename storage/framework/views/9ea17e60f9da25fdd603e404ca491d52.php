

<?php $__env->startSection('content'); ?>
    <div class="d-flex align-items-center mb-4 gap-2">
        <a href="<?php echo e(route('soldats.index')); ?>" class="text-muted text-decoration-none">Retour</a>
        <h4 class="fw-bold m-0">Modifier : <?php echo e($soldat->nom); ?> <?php echo e($soldat->prenom); ?></h4>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('soldats.update', $soldat->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="row g-4">
            <div class="col-md-7">
                <div class="bg-white rounded-3 shadow-sm p-4 border">
                    <h6 class="fw-bold mb-4">Identité</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Nom</label>
                            <input type="text" name="nom" class="form-control" value="<?php echo e($soldat->nom); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Prénom</label>
                            <input type="text" name="prenom" class="form-control" value="<?php echo e($soldat->prenom); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Matricule</label>
                            <input type="text" name="matricule" class="form-control" value="<?php echo e($soldat->matricule); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Téléphone</label>
                            <input type="text" name="telephone" class="form-control" value="<?php echo e($soldat->telephone); ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label text-muted" style="font-size: 0.85rem;">Grade</label>
        <input type="text" name="grade" class="form-control" value="<?php echo e(old('grade', $soldat->grade)); ?>" list="list_grades" required>
        <datalist id="list_grades">
            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($g); ?>">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </datalist>
    </div>
    <div class="col-md-4">
        <label class="form-label text-muted" style="font-size: 0.85rem;">Unité</label>
        <input type="text" name="unite" class="form-control" value="<?php echo e(old('unite', $soldat->unite)); ?>" list="list_unites" required>
        <datalist id="list_unites">
            <?php $__currentLoopData = $unites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($u); ?>">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </datalist>
    </div>
    <div class="col-md-4">
        <label class="form-label text-muted" style="font-size: 0.85rem;">Base d'affectation</label>
        <input type="text" name="base_affectation" class="form-control" value="<?php echo e(old('base_affectation', $soldat->base_affectation)); ?>" list="list_bases" required>
        <datalist id="list_bases">
            <?php $__currentLoopData = $bases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($b); ?>">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </datalist>
    </div>
</div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="bg-white rounded-3 shadow-sm p-4 border">
                    <h6 class="fw-bold mb-4">Photos (Vide = garder l'actuelle)</h6>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Photo de Face</label>
                        <input type="file" name="photo" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Profil Gauche</label>
                        <input type="file" name="photo_profil_gauche" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Profil Droit</label>
                        <input type="file" name="photo_profil_droit" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="<?php echo e(route('soldats.index')); ?>" class="btn btn-light border px-4">Annuler</a>
            <button type="submit" class="btn text-white px-4" style="background-color: var(--admin-green);">Mettre à jour</button>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\fama-id\resources\views/admin/soldats/edit.blade.php ENDPATH**/ ?>