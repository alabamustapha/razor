<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Crée un indice</div>
                    <div class="panel-body">


                        <?php echo Form::open(array(
                        'route' => 'indicedebase.store',
                         'method' => 'POST', 'class' => 'form-horizontal')); ?>

                        
                        <?php echo Form::label('indice', 'Indice'); ?>

                        <?php echo Form::text('indice', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Indice']); ?>


                        <?php echo Form::label('valeur', 'Valeur'); ?>

                        <?php echo Form::text('valeur', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Valeur de l\'indice de base']); ?>



                        <?php echo Form::submit('Ajouter',
                        ['class' => 'btn btn-group-justified', 'style' => 'margin-top:10px;']); ?>


                        <style>.btn-group-justified{background-color: lightsteelblue;margin-top:10px;}</style>


                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>