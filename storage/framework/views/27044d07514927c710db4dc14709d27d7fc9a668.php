<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Les produits</div>

                    <div class="panel-body">
                        <a href="<?php echo e(url('tarificateurbatiment')); ?>" style="background-color:#d08639!important; border-color: #d08639!important;" class="btn btn-primary">Tarificateur Bâtiment inférieur à 1500m2</a>
                        <a href="<?php echo e(url('tarificateurgroupama/nbr_sinistre')); ?>" style="background-color:#d08639!important; border-color: #d08639!important;" class="btn btn-primary">Tarificateur Bâtiment supérieur à 1500m2</a>
                        </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="panel panel-default">
                                <div class="panel-heading">Mes devis</div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="panel-body">
                                                <ul>
                                                    <?php $__currentLoopData = $devis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list_devis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                        <li>
                                                            <b>Devis <?php echo e(App\Models\Home::type_to_label($list_devis->type_product)); ?> n° <?php echo e($list_devis->id); ?> <?php echo e($list_devis->customer_nom); ?> <a href="<?php echo e(route('details', $list_devis->id)); ?>"><i class="fa fa-cog" aria-hidden="true"></i></a></b>
                                                        </li>

                                                        <?php echo e(date('d-m-Y', strtotime($list_devis->date_creation))); ?> - <?php echo e(number_format($list_devis->tarificateur_amount, 2)); ?> € - <?php echo e(App\Models\Home::display_last_status($list_devis->status)); ?>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                                <h4>Mes Anciens Devis</h4>
                                                <ul>
                                                    <?php $__currentLoopData = $old_devis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list_old_devis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                        <li>
                                                            <b>Devis <?php echo e(App\Models\Home::type_to_label($list_old_devis->type_product)); ?> n° <?php echo e($list_old_devis->id); ?> <?php echo e($list_old_devis->customer_nom); ?> <a href="<?php echo e(route('old_details', $list_old_devis->id)); ?>"><i class="fa fa-cog" aria-hidden="true"></i></a></b>
                                                        </li>

                                                        <?php echo e(date('d-m-Y', strtotime($list_old_devis->date_creation))); ?> - <?php echo e(number_format($list_old_devis->tarificateur_amount, 2)); ?> € - <?php echo e(App\Models\Home::display_last_status($list_old_devis->status)); ?>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="panel panel-default">
                                <div class="panel-heading">Mes Contrats</div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="panel-body">
                                                <ul>
                                                    <?php $__currentLoopData = $devis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list_devis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if( App\Models\TarificateurBatiment::search_status($list_devis->status, "30-" )): ?>
                                                            <li>
                                                                <b>Contrat <?php echo e(App\Models\Home::type_to_label($list_devis->type_product)); ?> n° <?php echo e(App\Models\Home::display_id_contrat($list_devis->id_contrat)); ?> <?php echo e($list_devis->customer_nom); ?> <a href="<?php echo e(route('details', $list_devis->id)); ?>"><i class="fa fa-cog" aria-hidden="true"></i></a></b>
                                                            </li>

                                                            <?php echo e(date('d-m-Y', strtotime($list_devis->date_creation))); ?> - <?php echo e(number_format($list_devis->tarificateur_amount, 2)); ?> € - <?php echo e(App\Models\Home::display_last_status($list_devis->status)); ?>

                                                            <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                                <h4>Mes Anciens Contrats</h4>
                                                <ul>
                                                    <?php $__currentLoopData = $old_devis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list_old_devis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if( App\Models\TarificateurBatiment::search_status($list_old_devis->status, "30-" )): ?>
                                                            <li>
                                                                <b>Contrat <?php echo e(App\Models\Home::type_to_label($list_old_devis->type_product)); ?> n° <?php echo e(App\Models\Home::display_id_contrat($list_old_devis->id_contrat)); ?> <?php echo e($list_old_devis->customer_nom); ?> <a href="<?php echo e(route('old_details', $list_old_devis->id)); ?>"><i class="fa fa-cog" aria-hidden="true"></i></a></b>
                                                            </li>
                                                            <?php echo e(date('d-m-Y', strtotime($list_old_devis->date_creation))); ?> - <?php echo e(number_format($list_old_devis->tarificateur_amount, 2)); ?> € - <?php echo e(App\Models\Home::display_last_status($list_old_devis->status)); ?>

                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>