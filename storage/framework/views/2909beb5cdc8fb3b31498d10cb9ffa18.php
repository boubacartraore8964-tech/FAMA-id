

<?php $__env->startSection('content'); ?>
    <div class="d-flex align-items-center mb-4 gap-2">
        <a href="<?php echo e(route('soldats.index')); ?>" class="text-muted text-decoration-none"><i class="bi bi-chevron-left"></i></a>
        <h4 class="fw-bold m-0">Enregistrer un soldat</h4>
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

    <form action="<?php echo e(route('soldats.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="row g-4">
            <div class="col-md-7">
                <div class="bg-white rounded-3 shadow-sm p-4 border h-100">
                    <h6 class="fw-bold mb-4">Identité</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted" style="font-size: 0.85rem;">Nom</label>
                            <input type="text" name="nom" class="form-control" value="<?php echo e(old('nom')); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted" style="font-size: 0.85rem;">Prénom</label>
                            <input type="text" name="prenom" class="form-control" value="<?php echo e(old('prenom')); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted" style="font-size: 0.85rem;">Matricule</label>
                            <input type="text" name="matricule" class="form-control" value="<?php echo e(old('matricule')); ?>" required placeholder="Ex: MAT-204871">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted" style="font-size: 0.85rem;">Numéro de téléphone</label>
                            <input type="text" name="telephone" class="form-control" value="<?php echo e(old('telephone')); ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label text-muted" style="font-size: 0.85rem;">Grade</label>
        <input type="text" name="grade" class="form-control" value="<?php echo e(old('grade')); ?>" list="list_grades" required placeholder="Choisir ou taper">
        <datalist id="list_grades">
            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($g); ?>">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </datalist>
    </div>
    <div class="col-md-4">
        <label class="form-label text-muted" style="font-size: 0.85rem;">Unité</label>
        <input type="text" name="unite" class="form-control" value="<?php echo e(old('unite')); ?>" list="list_unites" required placeholder="Choisir ou taper">
        <datalist id="list_unites">
            <?php $__currentLoopData = $unites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($u); ?>">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </datalist>
    </div>
    <div class="col-md-4">
        <label class="form-label text-muted" style="font-size: 0.85rem;">Base d'affectation</label>
        <input type="text" name="base_affectation" class="form-control" value="<?php echo e(old('base_affectation')); ?>" list="list_bases" required placeholder="Choisir ou taper">
        <datalist id="list_bases">
            <?php $__currentLoopData = $bases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($b); ?>">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </datalist>
    </div>
</div>
                    
                    <div class="mt-4 p-3 rounded" style="background-color: #F8FAFC; border: 1px dashed #CBD5E1; font-size: 0.8rem; color: #64748B;">
                        <i class="bi bi-info-circle"></i> L'identifiant unique est créé automatiquement à l'enregistrement.
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="bg-white rounded-3 shadow-sm p-4 border h-100">
                    <h6 class="fw-bold mb-4">Photos du visage</h6>
                    
                    <div class="mb-4">
                        <label class="form-label text-muted" style="font-size: 0.85rem;">Photo de Face (Obligatoire)</label>
                        <input type="file" name="photo" class="form-control" accept="image/*" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted" style="font-size: 0.85rem;">Profil Gauche (Optionnel)</label>
                        <input type="file" name="photo_profil_gauche" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted" style="font-size: 0.85rem;">Profil Droit (Optionnel)</label>
                        <input type="file" name="photo_profil_droit" class="form-control" accept="image/*">
                    </div>

                    <div class="text-muted" style="font-size: 0.75rem;">
                        <i class="bi bi-camera"></i> Les visages doivent être nets. L'IA vérifie la qualité à l'enregistrement.
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="<?php echo e(route('soldats.index')); ?>" class="btn btn-light border px-4">Annuler</a>
            <button type="submit" class="btn text-white px-4" style="background-color: var(--admin-green);">Enregistrer le soldat</button>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\fama-id\resources\views/admin/soldats/create.blade.php ENDPATH**/ ?>