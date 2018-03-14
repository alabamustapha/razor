<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Edition d'un affilié</h3></div>
                    <div class="panel-body">

                        <?php echo Form::model(
                          $user,
                          array(
                        'route' => array('user.update', $user->id),
                        'method' => 'PUT')); ?>


                        <?php echo Form::label('email', 'Adresse email'); ?>

                        <?php echo Form::text('email', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Adresse email']); ?>


                        <?php echo Form::label('aff_civility', 'Civilité'); ?>

                        <?php echo Form::select('aff_civility', ['0' => 'Monsieur', '1' => 'Madame ou Mademoiselle'],Null, ['class' => 'form-control' ],['placeholder' => 'Civilité']); ?>


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


                        <?php echo Form::label('aff_ref', 'Référence affilié'); ?>

                        <?php echo Form::text('aff_ref', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Référence affilié']); ?>


                        <?php echo Form::label('aff_message', 'Message'); ?>

                        <?php echo Form::textarea('aff_message', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Message']); ?>


                        <?php echo Form::label('aff_status_approved', 'Status'); ?>

                        <?php echo Form::select('aff_status_approved', ['0' => 'Inactif', '1' => 'Actif'],Null, ['class' => 'form-control' ],['placeholder' => 'Status']); ?>

                        <br>
                        <p>Test courtier <?php echo e($user->aff_link); ?></p>
                        <div>
                            <a href="<?php echo e(url('/user')); ?>">Retour</a> -
                            <?php if($user->aff_link == -1): ?>
                            <a href="<?php echo e(route('convert_aff', $user->id)); ?>">Convertir en courtier</a>
                                <?php else: ?>
                                <a href="<?php echo e(route('convert_courtier', $user->id)); ?>">Convertir en affilié</a>
                            <?php endif; ?>
                        </div>
                        <?php echo Form::submit('Modifier l\'affilié',
                        ['class' => 'btn btn-group-justified',
                        'style' => 'background-color: #d08639!important; border-color:#d08639!important;color:white;']); ?>


                        <style>.btn-group-justified{background-color: lightsteelblue}</style>


                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>