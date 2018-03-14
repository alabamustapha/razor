<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Dossier sur devis n°<?php echo e($tarif_bat->id); ?> <?php echo e($tarif_bat->customer_nom); ?></h3></div>
                    <div class="panel-body">
                        <p>Les étapes suivants ont été passées et historisées sur ce dossier :</p>

                        <?php echo App\Models\TarificateurBatiment::display_all_status($tarif_bat->status)?>

                        <br>
                        <p>Les documents disponibles constitutifs du dossier :</p>
                        <ul>
                            <?php if($tarif_bat->type_product == 4): ?>
                                <li><a class="btn-orange-a" target="_blank" href="<?php echo e(url('devis_bat_groupama?id='.$tarif_bat->id)); ?>">Télécharger le devis</a></li>

                            <?php else: ?>

                                <li><a class="btn-orange-a" target="_blank" href="<?php echo e(url('devis_bat?id='.$tarif_bat->id)); ?>">Télécharger le devis</a></li>

                            <?php endif; ?>
                            <?php if(App\Models\TarificateurBatiment::search_status($tarif_bat->status, "30-")): ?>
                                <?php else: ?>
                                <li><a class="btn-orange-a" target="_blank" href="<?php echo e(route('modif_batiment_step_1',$tarif_bat->id)); ?>">Modifier le devis</a></li>
                            <?php endif; ?>
                        </ul>
                        <center><a class="btn-orange-a" href="<?php echo e(url('/home')); ?>">Retour</a></center>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>