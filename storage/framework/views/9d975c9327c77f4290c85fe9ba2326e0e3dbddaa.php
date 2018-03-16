<?php $__env->startSection('content'); ?>
    
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
               



                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Les devis et contrat</h3></div>
                    <div class="panel-body">
                        <h4>Gestion des devis et des contrats</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Type</th>
                                    <th>Nom client</th>
                                    <th>Date devis</th>
                                    <th>Tarif tarificateur</th>
                                    <th>Tarif client</th>
                                    <th>Prime brute fournisseur</th>
                                    <th>Commission affilié</th>
                                    <th>Commission prévidia</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $devis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $devis_contrat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>


                                        <td><a class="btn-orange-a" href="<?php echo e(route('editioncontrat', $devis_contrat->id)); ?>">Consulter</a></td>
                                        <td><?php echo e(App\Models\TarificateurBatiment::type_to_label($devis_contrat->type_product)); ?></td>
                                        <td><?php echo e($devis_contrat->customer_nom); ?></td>
                                        <td><?php echo e(date('d-m-Y', strtotime($devis_contrat->date_creation))); ?></td>
                                        <td><?php echo e(App\Models\TarificateurBatiment::format_tarif($devis_contrat->tarificateur_amount)); ?></td>
                                        <td><?php echo e(App\Models\TarificateurBatiment::format_tarif($devis_contrat->customer_amount)); ?></td>
                                        <td><?php echo e(App\Models\TarificateurBatiment::format_tarif($devis_contrat->partner_amount * 0.90 )); ?></td>
                                        <td><?php echo e(App\Models\TarificateurBatiment::format_tarif($devis_contrat->affiliate_amount)); ?></td>
                                        <td><?php echo e(App\Models\TarificateurBatiment::format_tarif($devis_contrat->tarificateur_amount * 0.83 * 0.1 + $devis_contrat->partner_amount * 0.10)); ?></td>
                                        <td><?php echo e(App\Models\TarificateurBatiment::display_last_status($devis_contrat->status)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>


                        <?php echo e($devis->render()); ?>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Les anciens devis et contrat</h3></div>
                    <div class="panel-body">
                        <h4>Gestion des devis et des contrats ancien tarificateur</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Type</th>
                                    <th>Nom client</th>
                                    <th>Date devis</th>
                                    <th>Tarif tarificateur</th>
                                    <th>Tarif client</th>
                                    <th>Prime brute fournisseur</th>
                                    <th>Commission affilié</th>
                                    <th>Commission prévidia</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $old_devis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $old_devis_contrat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>


                                        <td><a class="btn-orange-a" href="<?php echo e(route('oldeditioncontrat', $old_devis_contrat->id)); ?>">Consulter</a></td>
                                        <td><?php echo e(App\Models\TarificateurBatiment::type_to_label($old_devis_contrat->type_product)); ?></td>
                                        <td><?php echo e($old_devis_contrat->customer_nom); ?></td>
                                        <td><?php echo e(date('d-m-Y', strtotime($old_devis_contrat->date_creation))); ?></td>
                                        <td><?php echo e(App\Models\TarificateurBatiment::format_tarif($old_devis_contrat->tarificateur_amount)); ?></td>
                                        <td><?php echo e(App\Models\TarificateurBatiment::format_tarif($old_devis_contrat->customer_amount)); ?></td>
                                        <td><?php echo e(App\Models\TarificateurBatiment::format_tarif($old_devis_contrat->partner_amount * 0.90 )); ?></td>
                                        <td><?php echo e(App\Models\TarificateurBatiment::format_tarif($old_devis_contrat->affiliate_amount)); ?></td>
                                        <td><?php echo e(App\Models\TarificateurBatiment::format_tarif($old_devis_contrat->tarificateur_amount * 0.83 * 0.1 + $devis_contrat->partner_amount * 0.10)); ?></td>
                                        <td><?php echo e(App\Models\TarificateurBatiment::display_last_status($old_devis_contrat->status)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>



                        <?php echo e($old_devis->render()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>