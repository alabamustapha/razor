<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Mes indices de base</h3></div>
                    <div class="panel-body">
                        <p>Le montant doit être spécifié avec un point et non une virgule.</p>
                        
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Indice</th>
                                <th>Valeur</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $indice_de_base; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                <tr>
                                    <td><p><?php echo e($indice->indice); ?></p></td>
                                    <td><?php echo e($indice->valeur); ?></td>
                                    <td id="flex">
                                        <a href="<?php echo e(route('indicedebase.edit', $indice->id)); ?>"><i class="fa fa-pencil-square-o"></i></a>

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