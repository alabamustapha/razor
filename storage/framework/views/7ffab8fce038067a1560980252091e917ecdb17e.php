<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Modifier l'indice</h3></div>
                    <div class="panel-body">

                        <?php echo Form::model(
                          $indice_de_base,
                          array(
                        'route' => array('indicedebase.update', $indice_de_base->id),
                        'method' => 'PUT')); ?>


                        <p><?php echo e($indice_de_base->indice); ?></p>

                        <?php echo Form::label('valeur', 'Valeur'); ?>

                        <?php echo Form::text('valeur', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Valeur']); ?>

                        <br>

                        <?php echo Form::submit('Modifier',
                        ['class' => 'btn btn-group-justified btn-orange']); ?>


                        <style>.btn-group-justified{background-color: lightsteelblue}</style>


                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>