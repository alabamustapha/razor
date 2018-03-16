<?php $__env->startSection('content'); ?>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $.ajax({
                url: '<?php echo e(URL::action('TarificateurGroupamaController@test_result')); ?>',
                type: 'POST',
                data: $('#tarificateur_groupama').serialize(),
                success: function(reponse) {
                    console.log(reponse)
                    $('div#result').html(reponse);
                }
            });

            $('#tarificateur_groupama').change(function() {

                $.ajax({
                    url: '<?php echo e(URL::action('TarificateurGroupamaController@test_result')); ?>',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(reponse) {
                        $('div#result').html(reponse);
                    }
                });
            });
        });
    </script>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Assurance batiment \ Devis</strong> - Etape 1/4</div>
                    <div class="panel-body">
                        <form class="form-horizontal" id="tarificateur_groupama" method="POST">
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <div class="container">
                                <div class="row">

                                    <?php if($value_in_nbr_sinistre >= 10): ?>
                                        <div class="col-md-8">
                                            <label class="col-md-4 control-label">Nombre de sinistres trop élévé !</label>
                                            <a href="<?php echo e(url('tarificateurgroupama/nbr_sinistre')); ?>">Retour</a>
                                        </div>
                                        <?php else: ?>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="in_nombre_surface" class="col-md-4 control-label">Surface</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" type="text" name="in_nombre_surface" value="<?php echo e($value_in_nbr_surface); ?>">
                                                </div>
                                                
                                            </div>


                                            <div class="form-group">
                                                <label for="in_nombre_sinistres" class="col-md-4 control-label">Sinistre(s)</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" type="text" name="in_nombre_sinistres" value="<?php echo e($value_in_nbr_sinistre); ?>">
                                                </div>
                                                
                                            </div>                                           
                                            
                                            
                                            <?php if($value_in_nbr_sinistre == 0): ?>

                                            <?php elseif($value_in_nbr_sinistre == 1): ?>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input class="form-control" type="text" name="sinistre_1" placeholder="cout du sinistre €">                   
                                                </div>

                                            <?php elseif($value_in_nbr_sinistre == 2): ?>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input class="form-control" type="text" name="sinistre_1" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_1") ?><input class="form-control" type="text" name="sinistre_2" placeholder="cout du sinistre €">

                                            <?php elseif($value_in_nbr_sinistre == 3): ?>
                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input class="form-control" type="text" name="sinistre_1" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_1") ?><input class="form-control" type="text" name="sinistre_2" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_2") ?><input class="form-control" type="text" name="sinistre_3" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>
                                                

                                            <?php elseif($value_in_nbr_sinistre == 4): ?>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input class="form-control" type="text" name="sinistre_1" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_1") ?><input class="form-control" type="text" name="sinistre_2" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_2") ?><input class="form-control" type="text" name="sinistre_3" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_3") ?><input class="form-control" type="text" name="sinistre_4" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>                                     

                                            <?php elseif($value_in_nbr_sinistre == 5): ?>
                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input class="form-control" type="text" name="sinistre_1" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_1") ?><input class="form-control" type="text" name="sinistre_2" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_2") ?><input class="form-control" type="text" name="sinistre_3" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_3") ?><input class="form-control" type="text" name="sinistre_4" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_4") ?><input class="form-control" type="text" name="sinistre_5" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                            <?php elseif($value_in_nbr_sinistre == 6): ?>
                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input class="form-control" type="text" name="sinistre_1" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_1") ?><input class="form-control" type="text" name="sinistre_2" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_2") ?><input class="form-control" type="text" name="sinistre_3" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_3") ?><input class="form-control" type="text" name="sinistre_4" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_4") ?><input class="form-control" type="text" name="sinistre_5" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_5") ?><input class="form-control" type="text" name="sinistre_6" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>                                          

                                            <?php elseif($value_in_nbr_sinistre == 7): ?>
                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input class="form-control" type="text" name="sinistre_1" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_1") ?><input class="form-control" type="text" name="sinistre_2" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_2") ?><input class="form-control" type="text" name="sinistre_3" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_3") ?><input class="form-control" type="text" name="sinistre_4" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_4") ?><input class="form-control" type="text" name="sinistre_5" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_5") ?><input class="form-control" type="text" name="sinistre_6" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_6") ?><input class="form-control" type="text" name="sinistre_7" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>                                               

                                            <?php elseif($value_in_nbr_sinistre == 8): ?>
                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input class="form-control" type="text" name="sinistre_1" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_1") ?><input class="form-control" type="text" name="sinistre_2" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_2") ?><input class="form-control" type="text" name="sinistre_3" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_3") ?><input class="form-control" type="text" name="sinistre_4" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_4") ?><input class="form-control" type="text" name="sinistre_5" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_5") ?><input class="form-control" type="text" name="sinistre_6" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_6") ?><input class="form-control" type="text" name="sinistre_7" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_7") ?><input class="form-control" type="text" name="sinistre_8" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>                                              

                                            <?php elseif($value_in_nbr_sinistre == 9): ?>
                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input class="form-control" type="text" name="sinistre_1" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_1") ?><input class="form-control" type="text" name="sinistre_2" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_2") ?><input class="form-control" type="text" name="sinistre_3" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_3") ?><input class="form-control" type="text" name="sinistre_4" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_4") ?><input class="form-control" type="text" name="sinistre_5" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_5") ?><input class="form-control" type="text" name="sinistre_6" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_6") ?><input class="form-control" type="text" name="sinistre_7" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_7") ?><input class="form-control" type="text" name="sinistre_8" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                    <div class="col-md-6">
                                                        <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_8") ?><input class="form-control" type="text" name="sinistre_9" placeholder="cout du sinistre €">
                                                        
                                                    </div>
                                                </div>
                                                
                                            <?php endif; ?>

                                            <div class="form-group">
                                                <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                <div class="col-md-6">
                                                    <?php echo App\Models\TarificateurGroupama::display_select($in_zone, "in_zone") ?>
                                                    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="col-md-4 control-label">&nbsp;</label>

                                                <div class="col-md-6">
                                                    <?php echo App\Models\TarificateurGroupama::display_select($coef_annee_construction, "coef_annee_construction") ?>
                                                    
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_radio($coef_minorations_possibles, "in_coef_minorations_possibles") ?>
                                                <br>
                                                <input type="hidden" name="in_marge" value="1.18">

                                        </div>
                                        <div class="col-md-4">
                                            <div id="result"></div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>