    

<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Ajouter un affilié</div>
                    <div class="panel-body">


                        <?php echo Form::open(array(
                        'route' => 'user.store',
                         'method' => 'POST', 'class' => 'form-horizontal')); ?>


                        <?php echo Form::label('email', 'Adresse email'); ?>

                        <?php echo Form::text('email', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Adresse email']); ?>


                        <?php echo Form::label('aff_fname', 'Prénom'); ?>

                        <?php echo Form::text('aff_fname', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Prénom']); ?>


                        <?php echo Form::label('aff_lname', 'Nom'); ?>

                        <?php echo Form::text('aff_lname', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Nom']); ?>


                        <?php echo Form::label('aff_company', 'Société'); ?>

                        <?php echo Form::text('aff_company', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Société']); ?>


                        <?php echo Form::label('aff_adresse', 'Adresse'); ?>

                        <?php echo Form::text('aff_adresse', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Adresse']); ?>


                        <?php echo Form::label('aff_city', 'Ville'); ?>

                        <?php echo Form::text('aff_city', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Ville']); ?>


                        <?php echo Form::label('aff_zip', 'Code postale'); ?>

                        <?php echo Form::text('aff_zip', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Code postale']); ?>


                        <?php echo Form::label('aff_tel', 'Téléphone'); ?>

                        <?php echo Form::text('aff_tel', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Téléphone']); ?>


                        <?php echo Form::label('aff_orias', 'N°Orias'); ?>

                        <?php echo Form::text('aff_orias', null,
                        ['class' => 'form-control',
                        'placeholder' => 'N°Orias']); ?>


                        <?php echo Form::label('aff_message', 'Message'); ?>

                        <?php echo Form::text('aff_message', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Message']); ?>

                        <br>
                        <?php echo Form::submit('Ajouter un affilié',
                        ['class' => 'btn btn-group-justified']); ?>


                        <style>.btn-group-justified{background-color: lightsteelblue}</style>


                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>