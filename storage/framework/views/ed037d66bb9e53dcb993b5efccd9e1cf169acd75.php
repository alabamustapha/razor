    <?php $__env->startSection('content'); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Recherche</div>
                        <div class="panel-body">

                        <?php echo Form::open(array(
                        'url' => 'tarificateurbatiment/result_search',
                         'method' => 'PUT', 'class' => 'form-horizontal')); ?>


                        <?php echo Form::select('type_product', array('0' => 'Nouveau Devis', '1' => 'Ancien Devis'),null, ['class' => 'form-control']); ?>


                        <?php echo Form::select('product_choice', array('0' => 'N° Devis', '1' => 'Par courtier'), null, ['class' => 'form-control'] ); ?>

                        
                        <?php echo Form::text('search', null,
                        ['class' => 'form-control',
                        'placeholder' => 'N°Devis, Courtier']); ?>


                        
                        <br>
                        <?php echo Form::submit('Rechercher',
                        ['class' => 'btn btn-group-justified btn-orange']); ?>


                        <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>