

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Modifier le Vérificateur</h1>
    <a href="<?php echo e(route('verificateurs.index')); ?>" class="btn btn-outline-secondary">Retour</a>
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

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?php echo e(route('verificateurs.update', $verificateur->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nom complet de l'agent</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $verificateur->name)); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Poste affecté</label>
                    <input type="text" name="poste" class="form-control" value="<?php echo e(old('poste', $verificateur->poste)); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Identifiant de connexion</label>
                    <input type="text" name="email" class="form-control" value="<?php echo e(old('email', $verificateur->email)); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nouveau mot de passe (Laisser vide pour ne pas changer)</label>
                    <input type="password" name="password" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-fama">Mettre à jour le compte</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\fama-id\resources\views/admin/verificateurs/edit.blade.php ENDPATH**/ ?>