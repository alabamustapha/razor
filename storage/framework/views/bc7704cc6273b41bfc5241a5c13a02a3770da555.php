<?php $__env->startSection('styles'); ?>
<style>
    .html5buttons{
        margin-bottom: 20px;
    }
    td, th {
    white-space: nowrap;
    overflow: hidden;
    }

    table#report>tbody>tr:nth-of-type(odd){
        background-color: #fff;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div style="margin: 0 auto; width: 100%;"> 
                <!-- <div class="table-responsive">
                    <table id="report" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                                <th><?php echo e("Type d'opération"); ?></th>
                                <th><?php echo e("Numéro de client"); ?></th>
                                <th><?php echo e("Nom"); ?></th>
                                <th><?php echo e("Prénom"); ?></th>
                                <th><?php echo e("Numéro de police courtier"); ?></th>
                                <th><?php echo e("numéro de police CNAM"); ?></th>
                                <th><?php echo e("Produit"); ?></th>
                                <th><?php echo e("Capital assuré"); ?></th>
                                <th><?php echo e("Périodicité"); ?></th>
                                <th><?php echo e("Début d'effet"); ?></th>
                                <th><?php echo e("Fin d'effet"); ?></th>
                                <th><?php echo e("Code risque"); ?></th>
                                <th><?php echo e("Motif résiliation"); ?></th>
                                <th><?php echo e("TTC compagnie"); ?></th>
                                <th><?php echo e("Commission"); ?></th>
                                <th><?php echo e("Incendie"); ?></th>
                                <th><?php echo e("Incendie taux %"); ?></th>
                                <th><?php echo e("Incendie taxe"); ?></th>
                                <th><?php echo e("TOC"); ?></th>
                                <th><?php echo e("TOC taux %"); ?></th>
                                <th><?php echo e("TOC taxe"); ?></th>
                                <th><?php echo e("Dom elec"); ?></th>
                                <th><?php echo e("Dom elec taux %"); ?></th>
                                <th><?php echo e("Dom elect taxe"); ?></th>
                                <th><?php echo e("Renonciation recours"); ?></th>
                                <th><?php echo e("Renonciation recours taux %"); ?></th>
                                <th><?php echo e("Renonciation taxe"); ?></th>
                                <th><?php echo e("Vol"); ?></th>
                                <th><?php echo e("Vol taux %"); ?></th>
                                <th><?php echo e("Vol taxe"); ?></th>
                                <th><?php echo e("RC"); ?></th>
                                <th><?php echo e("RC taux %"); ?></th>
                                <th><?php echo e("RC taxe"); ?></th>
                                <th><?php echo e("Vandalisme"); ?></th>
                                <th><?php echo e("Vandalisme taux %"); ?></th>
                                <th><?php echo e("Vandalisme taxe"); ?></th>
                                <th><?php echo e("Perte d'exploitation"); ?></th>
                                <th><?php echo e("Perte d'exploitation taux %"); ?></th>
                                <th><?php echo e("Perte d'exploitation taxe"); ?></th>
                                <th><?php echo e("Bris de glace"); ?></th>
                                <th><?php echo e("Bris de glace taux %"); ?></th>
                                <th><?php echo e("Bris de glace taxe"); ?></th>
                                <th><?php echo e("Dégat des eaux"); ?></th>
                                <th><?php echo e("Dégat des eaux %"); ?></th>
                                <th><?php echo e("Dégat des eaux taxe"); ?></th>
                                <th><?php echo e("BDM"); ?></th>
                                <th><?php echo e("BDM taux %"); ?></th>
                                <th><?php echo e("BDM taxe"); ?></th>
                                <th><?php echo e("Cat Nat"); ?></th>
                                <th><?php echo e("Cat Nat taux %"); ?></th>
                                <th><?php echo e("Cat Nat taxe"); ?></th>
                                <th><?php echo e("Cat Tech"); ?></th>
                                <th><?php echo e("Cat Tech taux %"); ?></th>
                                <th><?php echo e("Cat Tech taxe"); ?></th>
                                <th><?php echo e("Attentat"); ?></th>
                                <th><?php echo e("Attentat taux %"); ?></th>
                                <th><?php echo e("Attentat taxe"); ?></th>
                                <th><?php echo e("Total Prime TTC"); ?></th>
                                <th><?php echo e("Total taxe"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $tarificateur_batiments_records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarificateur_batiments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $tarificateur_batiments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarificateur_batiment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                            <tr>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td><?php echo e($tarificateur_batiment->customer_nom); ?></td>
                                <td><?php echo e($tarificateur_batiment->data_proposant['in_customer_prenom']); ?></td>    
                                <td><?php echo e(display_id_contrat($tarificateur_batiment->id_contrat)); ?></td>     
                                <td><?php echo e('N/A'); ?></td>     
                                <td><?php echo e('Assurance ' . type_to_label($tarificateur_batiment->type_product)." ".strtolower($tarificateur_batiment->formule)); ?></td>   
                                <td>
                                <?php if($tarificateur_batiment->type_product == 3): ?>
                                    
                                    <?php if(preg_match('/ECO/',$tarificateur_batiment->formule)): ?>  
                                        <?php echo e(format_tarif(unserialize($tarificateur_batiment->data_product)['result_eco']['mobilier'])); ?>  
                                    <?php elseif(preg_match('/CONFORT/',$tarificateur_batiment->formule)): ?> 
                                       <?php echo e(format_tarif(unserialize($tarificateur_batiment->data_product)['result_confort']['mobilier'])); ?> 
                                    <?php elseif(preg_match('/PRESTIGE/',$tarificateur_batiment->formule)): ?> 
                                    
                                    <?php echo e(format_tarif(unserialize($tarificateur_batiment->data_product)['result_prestige']['mobilier'])); ?>

                                    
                                    <?php elseif(preg_match('/PNO/',$tarificateur_batiment->formule)): ?> 
                                        <?php echo e(format_tarif(0.00)); ?>

                                    <?php endif; ?>

                                <?php else: ?> 
                                    <?php echo e(format_tarif(0.00)); ?>

                                <?php endif; ?>

                                </td>
                                <td><?php echo e($tarificateur_batiment->periodicity); ?></td>
                                <td><?php echo e(date("d/m/Y à 00:00", $tarificateur_batiment->date_contract)); ?></td>
                                <td><?php echo e(date("d/m/Y à 00:00", strtotime("+1 year",$tarificateur_batiment->date_contract))); ?></td>
                                <td><?php echo e('N/A'); ?></td>
                                <td><?php echo e('N/A'); ?></td>
                                <td><?php echo e(format_tarif($tarificateur_batiment->customer_amount *0.6)); ?></td>    
                                <td><?php echo e('N/A'); ?></td>
        					    <td><?php echo e(format_tarif($tarificateur_batiment->calculations['cotisation_incendie_ht'])); ?></td>
                                <td><?php echo e("30%"); ?></td>
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['cotisation_incendie_taxe'])); ?></td>
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['repartition_tgn_ht'])); ?></td>
                                <td><?php echo e("9%"); ?></td>
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['repartition_tgn_taxe'])); ?></td>
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['repartition_dommageselectriques_ht'])); ?></td>
                                <td><?php echo e("9%"); ?></td>
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['repartition_dommageselectriques_taxe'])); ?></td>
                                <td><?php echo e('N/A'); ?></td>
                                <td><?php echo e('N/A'); ?></td>
                                <td><?php echo e('N/A'); ?></td>
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['repartition_vol_ht'])); ?></td>
                                <td><?php echo e("9%"); ?></td>
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['repartition_vol_taxe'])); ?></td>
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['repartition_rc_ht'])); ?></td>
                                <td>
                                    <?php if($tarificateur_batiment->formule == "OPTION PROPRIETAIRE NON OCCUPANT"): ?>
                                        <?php echo e("5%"); ?>

                                    <?php else: ?>	
                                        <?php echo e("21%"); ?>

                                    <?php endif; ?>    
                                </td>
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['repartition_rc_taxe'])); ?></td>
                                <td><?php echo e('N/A'); ?></td>
                                <td><?php echo e('N/A'); ?></td>
                                <td><?php echo e('N/A'); ?></td>
                                <td><?php echo e('N/A'); ?></td>
                                <td><?php echo e('N/A'); ?></td>
                                <td><?php echo e('N/A'); ?></td>
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['repartition_brisdeglaces_ht'])); ?></td>
                                <td><?php echo e("9%"); ?></td>
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['repartition_brisdeglaces_taxe'])); ?></td>    
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['repartition_degatsdeseaux_ht'])); ?></td>    
                                <td><?php echo e("9%"); ?></td>
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['repartition_degatsdeseaux_taxe'])); ?></td>    
                                <td><?php echo e('N/A'); ?></td>
                                <td><?php echo e('N/A'); ?></td>
                                <td><?php echo e('N/A'); ?></td>
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['cotisation_cn_ht'])); ?></td>    
                                <td><?php echo e("9%"); ?></td>
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['cotisation_cn_taxe'])); ?></td>    
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['cotisation_risques_technologiques_ht'])); ?></td>    
                                <td><?php echo e("9%"); ?></td>    
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['cotisation_risques_technologiques_taxe'])); ?></td>    
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['cotisation_attentats_ht'])); ?></td>    
                                <td><?php echo e("9%"); ?></td>    
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['cotisation_attentats_taxe'])); ?></td>    
                                <td><?php echo e(format_tarif($tarificateur_batiment->customer_amount *0.6 - $tarificateur_batiment->calculations['taxes_annuelles'])); ?></td>    
                                <td><?php echo e(format_tarif($tarificateur_batiment->calculations['taxes_annuelles'])); ?></td>    
                                
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   

                        </tbody>
                    </table>
                </div> -->
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function() {
     
        $('table#report').DataTable( {
                
                "scrollX": true,
                
                pageLength: 10,
                
                dom: '<"html5buttons"B>lTfgitp',
                
                buttons: [
                    {extend: 'csv', title: 'Report', text: 'Téléchager l\'extraction',},
                ],
                language:{
                    "decimal":        "",
                    "emptyTable":     "No data available in table",
                    "info":           "affichage _START_ to _END_ of _TOTAL_ entrées",
                    "infoEmpty":      "affichage 0 to 0 of 0 entrées",
                    "infoFiltered":   "(filtered from _MAX_ total entrées)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Afficher _MENU_ entrées",
                    "loadingRecords": "chargement...",
                    "processing":     "En traitement...",
                    "search":         "Rechercher:",
                    "zeroRecords":    "Aucun enregistrements correspondants trouvés",
                    "paginate": {
                        "first":      "Premier",
                        "last":       "dernier",
                        "next":       "Suivant",
                        "previous":   "Précédent"
                    },
                    "aria": {
                        "sortAscending":  ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    }
                }    
        });

        
    });
 </script>   
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.report', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>