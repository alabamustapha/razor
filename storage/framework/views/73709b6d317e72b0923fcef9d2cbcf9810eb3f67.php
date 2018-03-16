<?php $__env->startSection('content'); ?>


    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Les devis et contrats</h3></div>
                    <div class="panel-body">
                        <div>
                            <p>Dossier sur devis n°<?php echo e($tarif_bat->id); ?> <?php echo e($tarif_bat->customer_nom); ?>

                                <?php if($tarif_bat->id_contrat > 0): ?>
                                    , contrat n° <?php echo e(App\Models\TarificateurBatiment::display_id_contrat($tarif_bat->id_contrat)); ?>

                                <?php else: ?>
                            </p>
                            <?php endif; ?>

                            <br><br><table>
                                <?php if($tarif_bat->customer_amount > 0): ?>
                                    <p>Les données financières suivantes consituent le dossier :</p><ul>
                                        <li>Tarif annuel client : <?php echo e(App\Models\TarificateurBatiment::format_tarif($tarif_bat->customer_amount)); ?>€</li>
                                        <li>Prime brute partenaire : <?php echo e(App\Models\TarificateurBatiment::format_tarif($tarif_bat->customer_amount * 0.6)); ?>€</li>
                                        <li>Commission Groupe Corim : <?php echo e(App\Models\TarificateurBatiment::format_tarif($tarif_bat->customer_amount * 0.40)); ?>€</li>
                                    </ul>
                                <?php endif; ?>

                            </table>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Les étapes suivants ont été passées et historisées sur ce dossier :</p>
                                    <?php echo App\Models\TarificateurBatiment::display_all_status($tarif_bat->status)?>
                                </div>
                                <div class="col-md-6">
                                    <p>Les documents suivants constituent le dossier :</p>
                                    <?php if(App\Models\TarificateurBatiment::search_status($tarif_bat->status, "100-") || App\Models\TarificateurBatiment::search_status($tarif_bat->status, "30-")): ?>
                                        <ul>
                                            <?php if(App\Models\TarificateurBatiment::search_status($tarif_bat->status, "100-")): ?>
                                                <?php if($tarif_bat->type_product == 2): ?>
                                                <li><a class="btn-orange-a" target="_blank" href="<?php echo e(url('devis_bat?id='.$tarif_bat->id)); ?>">Télécharger le devis</a></li>
                                                <?php elseif($tarif_bat->type_product == 4): ?>
                                                <li><a class="btn-orange-a" target="_blank" href="<?php echo e(url('devis_bat_groupama?id='.$tarif_bat->id)); ?>">Télécharger le devis</a></li>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if(App\Models\TarificateurBatiment::search_status($tarif_bat->status, "30-")): ?>
                                                <li><a class="btn-orange-a" target="_blank" href="<?php echo e(url('letttrepdf?id='.$tarif_bat->id)); ?>">Télécharger la lettre d'envoi</a></li>
                                                <li><a class="btn-orange-a" target="_blank" href="<?php echo e(url('attestationpdf?id='.$tarif_bat->id)); ?>">Télécharger l'attestation d'assurance</a></li>
                                                <li><a class="btn-orange-a" target="_blank" href="<?php echo e(url('autorisationpdf?id='.$tarif_bat->id)); ?>">Télécharger l'autorisation de prélévement</a></li>
                                                <?php if($tarif_bat->type_product == 2): ?>
                                                <li><a class="btn-orange-a" target="_blank" href="<?php echo e(url('contratpdf?id='.$tarif_bat->id)); ?>">Télécharger le contrat</a></li>
                                                <?php elseif($tarif_bat->type_product == 4): ?>
                                                <li><a class="btn-orange-a" target="_blank" href="<?php echo e(url('contratgroupamapdf?id='.$tarif_bat->id)); ?>">Télécharger le contrat</a></li>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>

                        <?php if(App\Models\TarificateurBatiment::search_status($tarif_bat->status, "31-") || App\Models\TarificateurBatiment::search_status($tarif_bat->status, "32-") || App\Models\TarificateurBatiment::search_status($tarif_bat->status, "33-") || App\Models\TarificateurBatiment::search_status($tarif_bat->status, "34-") || App\Models\TarificateurBatiment::search_status($tarif_bat->status, "35-")): ?>
                        <?php endif; ?>
                            <?php if(App\Models\TarificateurBatiment::search_status($tarif_bat->status, "31-")): ?>
                            <?php elseif(App\Models\TarificateurBatiment::search_status($tarif_bat->status, "20-")): ?>

                                <center>
                                <?php if($tarif_bat->type_product == 2): ?>
                                    <form class="form-horizontal" action="<?php echo e(route('editioncontratpost2', $tarif_bat->id)); ?>" method="post" name="form_post_devis_ou_contrat">  
                                <?php elseif($tarif_bat->type_product == 4): ?>
                                    <form class="form-horizontal" action="<?php echo e(route('editioncontratpost3', $tarif_bat->id)); ?>" method="post" name="form_post_devis_ou_contrat">
                                <?php endif; ?>

                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                                        <b>Quel est l'état actuel du devis ?</b><br><br>
                                        <select name="add_status" class="form-control">
                                            <?php if(App\Models\TarificateurBatiment::type_to_label($tarif_bat->type_product) == "habitation"): ?>
                                                <option value="'21-'time().';25-'.time().';26-'.time().';50-'.time().';60-'.time().';70-'.time().';30-'.time().';"></option>
                                                <option value="<?php echo '21-'.time().';25-'.time().';26-'.time().';50-'.time().';60-'.time().';70-'.time().';30-'.time().';'?>"><?php echo e(App\Models\TarificateurBatiment::status_to_label1(20)); ?>;<?php echo e(App\Models\TarificateurBatiment::status_to_label1(21)); ?></option>
                                                <option value="<?php echo '22-'.time().';25-'.time().';26-'.time().';50-'.time().';60-'.time().';70-'.time().';30-'.time().';'?>"><?php echo e(App\Models\TarificateurBatiment::status_to_label1(20)); ?>;<?php echo e(App\Models\TarificateurBatiment::status_to_label1(22)); ?></option>
                                                <option value="<?php echo '23-'.time().';25-'.time().';26-'.time().';50-'.time().';60-'.time().';70-'.time().';30-'.time().';'?>"><?php echo e(App\Models\TarificateurBatiment::status_to_label1(20)); ?>;<?php echo e(App\Models\TarificateurBatiment::status_to_label1(23)); ?></option>
                                                <option value="<?php echo '24-'.time().';25-'.time().';26-'.time().';50-'.time().';60-'.time().';70-'.time().';30-'.time().';'?>"><?php echo e(App\Models\TarificateurBatiment::status_to_label1(20)); ?>;<?php echo e(App\Models\TarificateurBatiment::status_to_label1(24)); ?></option>

                                            <?php elseif(App\Models\TarificateurBatiment::type_to_label($tarif_bat->type_product) == 'batiment'): ?>
                                                    <option value="<?php echo '21-'.time().';25-'.time().';26-'.time().';50-'.time().';60-'.time().';70-'.time().';30-'.time().';'?>" selected><?php echo e(App\Models\TarificateurBatiment::status_to_label1(20)); ?>;<?php echo e(App\Models\TarificateurBatiment::status_to_label1(21)); ?></option>
                                            <?php elseif(App\Models\TarificateurBatiment::type_to_label($tarif_bat->type_product) == 'pne'): ?>
                                                <option value="<?php echo '28-'.time().';25-'.time().';26-'.time().';50-'.time().';60-'.time().';70-'.time().';30-'.time().';'?>" selected><?php echo e(App\Models\TarificateurBatiment::status_to_label1(20)); ?>;<?php echo e(App\Models\TarificateurBatiment::status_to_label1(28)); ?></option>

                                            <?php endif; ?>
                                        </select>
                                        <br>Date d'effet du contrat :<input type="text" name="in_date_contract_days" value="<?php echo date("d",time()) ?>" size="1">/<input type="text" name="in_date_contract_months" value="<?php echo date("m",time()) ?>" size="1">/<input type="text" name="in_date_contract_years" value="<?php echo date("Y",time()) ?>" size="3">
                                        <br>Périodicité : <input type="radio" name="in_periodicity" value="1" checked>Annuelle <input type="radio" name="in_periodicity" value="2">Semestrielle <input type="radio" name="in_periodicity" value="4">Trimestrielle <input type="radio" name="in_periodicity" value="12">Mensuelle
                                        <br><a class="btn-orange-a" href="<?php echo e(route('editioncontrat', $tarif_bat->id)); ?>">Retour</a>- <button class="btn btn-orange" type="submit">Valider</button>
                                    </form>
                                </center>
                            <?php elseif(App\Models\TarificateurBatiment::search_status($tarif_bat->status, "10-") || App\Models\TarificateurBatiment::search_status($tarif_bat->status, "11-")): ?>
                                <center>
                                    <form class="form-horizontal" action="<?php echo e(route('editioncontratpost', $tarif_bat->id)); ?>" method="post" name="form_post_devis_ou_contrat">
                                        <b>Quel est l'état actuel du devis ?</b><br><br>
                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                                        <select name="add_status" class="form-control">
                                            <option value="<?php echo '11-'.time().';35-'.time().';'?>"><?php echo e(App\Models\TarificateurBatiment::status_to_label1(11)); ?>;<?php echo e(App\Models\TarificateurBatiment::status_to_label1(35)); ?></option>
                                            <option value="<?php echo '20-'.time().';31-'.time().';'?>"><?php echo e(App\Models\TarificateurBatiment::status_to_label1(20)); ?>;<?php echo e(App\Models\TarificateurBatiment::status_to_label1(31)); ?></option>
                                            <option value="<?php echo '20-'.time().';32-'.time().';'?>"><?php echo e(App\Models\TarificateurBatiment::status_to_label1(20)); ?>;<?php echo e(App\Models\TarificateurBatiment::status_to_label1(32)); ?></option>
                                            <option value="<?php echo '20-'.time().';33-'.time().';'?>"><?php echo e(App\Models\TarificateurBatiment::status_to_label1(20)); ?>;<?php echo e(App\Models\TarificateurBatiment::status_to_label1(33)); ?></option>
                                            <option value="<?php echo '20-'.time().';34-'.time().';'?>"><?php echo e(App\Models\TarificateurBatiment::status_to_label1(20)); ?>;<?php echo e(App\Models\TarificateurBatiment::status_to_label1(34)); ?></option>

                                            <option value="<?php echo '20-'.time().';27-'.time().';'?>" selected><?php echo e(App\Models\TarificateurBatiment::status_to_label1(20)); ?>;<?php echo e(App\Models\TarificateurBatiment::status_to_label1(27)); ?></option>
                                        </select>
                                        <br>
                                        <br>
                                        <a class="btn-orange-a" href="<?php echo e(route('editioncontrat', $tarif_bat->id)); ?>">Retour</a>- <button type="submit" class="btn btn-orange">Valider</button>
                                    </form>
                                </center>
                            <?php else: ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>