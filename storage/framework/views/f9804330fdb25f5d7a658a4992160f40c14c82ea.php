<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading title_espace_pro"><center>ESPACE PROFESSIONNELS</center></div>
                    <div class="panel-body">
                        <div>
                            <strong>Assurance batiment \ Devis</strong> - Etape 4/4
                        </div>
                        <div>
                            <p>Votre devis assurance batiment a été enregistré (référence #<?php echo e($contrat); ?>). Vous pouvez télécharger le devis correspondant à votre client en cliquant sur le lien ci-dessous </p>
                        </div>
                        <div class="body_step3">
                            <a class="btn-orange-a" target="_blank" href="<?php echo e(url('devis_bat?id='.$contrat)); ?>">Télécharger le devis</a> - <a
                                    href="<?php echo e(url('/home')); ?>">Retour au menu</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>