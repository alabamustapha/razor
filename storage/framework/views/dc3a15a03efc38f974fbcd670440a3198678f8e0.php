<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading title_espace_pro"><center>ESPACE PROFESSIONNELS</center></div>
                    <div class="panel-body">
                        <div>
                            <strong>Assurance batiment \ Devis</strong> - Etape 3/4
                        </div>
                        <div class="body_step3">
                            <a href="<?php echo e(url('tarificateurbatiment/tarifbat_step2')); ?>">Revenir à l'étape 2</a> - <a class="btn-orange-a" href="<?php echo e(url('tarificateurbatiment/tarifbat_step4')); ?>">Enregistrer et télécharger le devis</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>