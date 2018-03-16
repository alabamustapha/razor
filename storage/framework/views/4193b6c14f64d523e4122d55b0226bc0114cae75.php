<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Menu</div>
                    <div class="panel-body">
                        Votre compte a été créé avec succès.
                        <br>
                        Votre compte demeure inactif environ 48h tant que l'administrateur du site n'a pas validé et activé votre compte.
                        <br>
                        Vous êtes prévenu(e) par e-mail lorsque votre compte est activé.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>