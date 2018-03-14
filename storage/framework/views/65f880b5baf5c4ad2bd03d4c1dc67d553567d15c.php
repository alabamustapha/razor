<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Les affiliés</h3></div>
                    <div class="panel-body">
                        <h4>Gestion des affilié et des courtiers</h4>
                        <a class="btn-orange-a" href="<?php echo e(route('user.create')); ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i>Ajouter un affilié</a>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Status</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Ville</th>
                                <th>Date d'inscription</th>
                                <th>Dernière connexion</th>
                                <th>Nombre de courtier</th>
                                <th>Réf affilié</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_affil): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>


                                    <td><?php if($user_affil->aff_status_approved == 1): ?>
                                            <p style="color: green">Actif</p>

                                        <?php else: ?>
                                            <p style="color: red">Inactif</p>

                                        <?php endif; ?></td>

                                    <td>
                                        <?php if($user_affil->aff_civility == 0): ?>
                                            M.
                                        <?php else: ?>
                                            Mme.
                                        <?php endif; ?>
                                        <?php echo e($user_affil->aff_lname); ?></td>
                                    <td><?php echo e($user_affil->aff_fname); ?></td>
                                    <td><?php echo e($user_affil->aff_city); ?></td>
                                    <td><?php echo e($user_affil->created_at); ?></td>
                                    <td><?php echo e($user_affil->updated_at); ?></td>
                                    <td><?php echo count($user_affil->aff_link) ?></td>
                                    <td><?php echo e($user_affil->aff_ref); ?></td>
                                    <td><a href="<?php echo e(route('user.edit', $user_affil->id)); ?>"><i class="fa fa-pencil-square-o"></i></a>
                                        <a href=""><i style="color: red;" class="fa fa-times" aria-hidden="true"></i></a><br>
                                        <a class="btn-orange-a" href="<?php echo e(route('courtier_affilie', $user_affil->id)); ?>">Gérer les courtiers</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>