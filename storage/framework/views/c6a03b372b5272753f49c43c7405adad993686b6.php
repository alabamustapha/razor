<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading title_espace_pro"><center>ESPACE PROFESSIONNELS</center></div>
                    <div class="panel-body">
                        <div>
                            <label><strong>Assurance batiment \ Devis</strong> - Etape 2/4</label>
                        </div>
                        <form action="<?php echo e(url('tarificateurgroupama/tarifgroupama_step3')); ?>" method="post" name="form_proposant_s2"><center><table><tr><td valign="top" width="50%">
                                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                                            <table class="tarificateur" cellspacing="0" cellpadding="1">
                                                <tr bgcolor="#C0C0C0"><td><b>LE PROPOSANT</b></td><td></td></tr>
                                                <tr><td>Sigle</td><td><select name="in_customer_sigle" style="width:190px;">
                                                            <option value="M.">M.</option>
                                                            <option value="Mme">Mme</option>
                                                            <option value="Mlle">Mlle</option>
                                                            <option value="Eurl">Eurl</option>
                                                            <option value="Sarl">Sarl</option>
                                                            <option value="SA">SA</option>
                                                            <option value="Sté">Sté</option>
                                                            <option value="SCI">SCI</option>
                                                            <option value="Copro">Copro</option>
                                                            <option value="Syndic">Syndic</option>
                                                            <option value="Assoc">Assoc</option>
                                                        </select></td></tr>
                                                <tr><td>Nom</td><td><input type="text" name="in_customer_nom" value="" size="33"></td></tr>
                                                <tr><td>Prénom</td><td><input type="text" name="in_customer_prenom" value="" size="33"></td></tr>
                                                <tr><td valign="top">Adresse</td><td><textarea name="in_customer_adresse" cols="40" rows="5"></textarea></td></tr>
                                                <tr><td>Code postal</td><td><input type="text" name="in_customer_codepostal" value="" maxlength="5" size="4"></td></tr>
                                                <tr><td>Ville</td><td><input type="text" name="in_customer_ville" value="" size="33"></td></tr>
                                                <tr><td>Date de naissance</td><td><input type="text" name="in_customer_datedenaissance" value="" size="33"></td></tr>
                                                <tr><td>Téléphone</td><td><input type="text" name="in_customer_telephone" value="" size="33"></td></tr>
                                                <tr><td>Fax</td><td><input type="text" name="in_customer_fax" value="" size="33"></td></tr>
                                                <tr><td>Courriel</td><td><input type="text" name="in_customer_courriel" value="" size="33"></td></tr>
                                            </table></td><td valign="top" width="50%">
                                            <table class="tarificateur" cellspacing="0" cellpadding="1">
                                                <tr bgcolor="#C0C0C0"><td><b>CARACTERISTIQUES DU RISQUE</b></td><td><b></b></td></tr>
                                                <tr><td valign="top">Adresse</td><td><textarea name="in_risk_adresse" cols="40" rows="5"></textarea></td></tr>
                                                
                                                <tr><td>Code postal</td><td><input type="text" name="in_risk_codepostal" value="" maxlength="5" size="1"></td></tr>
                                                <tr><td>Ville</td><td><input type="text" name="in_risk_ville" value="" size="33"></td></tr>

                                                <tr><td>Occupant</td><td>Oui <input type="radio" value="1" name="in_risk_occupant" checked> Non <input type="radio" value="0" name="in_risk_occupant" >

                                                <tr><td>Nature du risque</td><td><select name="in_risk_naturerisque" style="width:190px;">
                                                            <option value="Maison particulière">Maison particulière</option>
                                                            <option value="Immeuble collectif">Immeuble collectif</option>
                                                        </select></td></tr>

                                                <tr><td>Résidence</td><td><select name="in_risk_residence" style="width:190px;">
                                                            <option value="Immeuble de rapport">Immeuble de rapport</option>
                                                            <option value="Coproprieté">Coproprieté</option>
                                                        </select></td></tr>

                                            </table>
                                        </td></tr></table><div class="form_field"><a href="<?php echo e(url('home')); ?>">Annuler</a> - <button class="btn-orange-a" style="border: none!important; background-color: transparent" type="submit">Aller à l'étape 3</button></div></center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>