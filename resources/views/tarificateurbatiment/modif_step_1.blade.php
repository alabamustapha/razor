@extends('layouts.app')

@section('content')

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $.ajax({
                url: '{{ URL::action('TarificateurBatimentController@result_tarif_modif') }}',
                type: 'POST',
                data: $('#tarificateur_batiment').serialize(),
                success: function(reponse) {
                    console.log(reponse)
                    $('div#result').html(reponse);
                }
            });

            $('#tarificateur_batiment').change(function() {
                if (tarificateur_batiment.in_nombre_sinistres.value_in_nombre_sinistre < 0 ||  (parseInt(tarificateur_batiment.in_nombre_sinistres.value_in_nombre_sinistre) != tarificateur_batiment.in_nombre_sinistres.value_in_nombre_sinistre))
                {
                    tarificateur_batiment.in_nombre_sinistres.value_in_nombre_sinistre = 0;
                    alert("Le nombre de sinistre(s) est égal à 0 ou supérieur.");
                } else if (tarificateur_batiment.in_nombre_surface.value_in_nombre_surface > 2500 ||  (parseInt(tarificateur_batiment.in_nombre_surface.value_in_nombre_surface)!=tarificateur_batiment.in_nombre_surface.value_in_nombre_surface))
                {
                    tarificateur_batiment.in_nombre_surface.value_in_nombre_surface = 0;
                    alert("La surface développée ne peut être supérieure à 2500 m2.");
                } else {}

                $.ajax({
                    url: '{{ URL::action('TarificateurBatimentController@result_tarif_modif') }}',
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
                    <div class="panel-heading"><strong>Modification Assurance batiment \ Devis</strong> - Etape 1/4</div>
                    <div class="panel-body">

                        <form id="tarificateur_batiment" method="post" action="{{ route('modif_step_1_post',$devis_id) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <center>
                                <table>
                                    <tr><td>
                                            <table>
                                                <tr><td valign="top">
                                                        <table class="tarificateur">
                                                            <tr bgcolor="#C0C0C0"><td> + <b>CONTEXTE CLIENT</b></td></td></tr>
                                                            <tr><td valign="middle">Nombre de sinistres / 36 mois</td><td><input type="text" name="in_nombre_sinistres" value="{{$product['in_nombre_sinistres']}}" placeholder="1" size="3"> sinistre(s)</td></tr>
                                                            <tr><td valign="middle">Surface développée</td><td><input type="text" name="in_nombre_surface" value="{{$product['in_nombre_surface']}}" size="3"> m2</td></tr>
                                                            <tr><td valign="middle">Département</td><td><?php echo App\Models\TarificateurBatiment::display_select1($coef_zone, "in_coef_zone", $product['in_coef_zone']) ?></td></tr>
                                                            <tr><td valign="middle">Aggravation occupation</td><td><?php echo App\Models\TarificateurBatiment::display_select1($coef_aggravation_occupation, "in_coef_aggravation_occupation",$product['in_coef_aggravation_occupation'])?></td></tr>
                                                            <tr><td valign="middle">Année de construction</td><td><?php echo App\Models\TarificateurBatiment::display_select1($coef_annee_construction, "in_coef_annee_construction", $product['in_coef_annee_construction'])?></td></tr>
                                                            <tr><td valign="middle">Antécédents</td><td><?php echo App\Models\TarificateurBatiment::display_select1($coef_antecedents, "in_coef_antecedents", $product['in_coef_antecedents']) ?> <td></tr>
                                                        </table>
                                                    </td><td valign="top">
                                                        <table class="tarificateur" cellspacing="0" cellpadding="1">
                                                            <tr bgcolor="#C0C0C0"><td valign="middle"><b>SPECIFICITES TECHNIQUES</b></td></tr>
                                                            <tr><td><input type="radio" name="in_coef_specificites_techniques_0" value="1" <?php if($product['in_coef_specificites_techniques_0'] == 1){echo 'checked="checked"';} ?> > Oui <input type="radio" name="in_coef_specificites_techniques_0" value="-1"<?php if($product['in_coef_specificites_techniques_0'] == -1){echo 'checked="checked"';} ?>>  Non &nbsp;&nbsp;&nbsp;Construction < 50 % matériaux durs</td></tr>
                                                            <tr><td><input type="radio" name="in_coef_specificites_techniques_1" value="1" <?php if($product['in_coef_specificites_techniques_1'] >= 1){echo 'checked="checked"';} ?> > Oui <input type="radio" name="in_coef_specificites_techniques_1" value="-1"<?php if($product['in_coef_specificites_techniques_1'] == -1){echo 'checked="checked"';} ?>>  Non &nbsp;&nbsp;&nbsp;Couverture < 90 % matériaux durs</td></tr>
                                                            <tr><td><input type="radio" name="in_coef_specificites_techniques_2" value="1" <?php if($product['in_coef_specificites_techniques_2'] >= 1){echo 'checked="checked"';} ?> > Oui <input type="radio" name="in_coef_specificites_techniques_2" value="-1"<?php if($product['in_coef_specificites_techniques_2'] == -1){echo 'checked="checked"';} ?>>  Non &nbsp;&nbsp;&nbsp;Vitres > 3 m2</td></tr>
                                                            <tr><td><input type="radio" name="in_coef_specificites_techniques_3" value="1" <?php if($product['in_coef_specificites_techniques_3'] >= 1){echo 'checked="checked"';} ?> > Oui <input type="radio" name="in_coef_specificites_techniques_3" value="-1"<?php if($product['in_coef_specificites_techniques_3'] == -1){echo 'checked="checked"';} ?>>  Non &nbsp;&nbsp;&nbsp;Couverture shingle</td></tr>
                                                            <tr><td><input type="radio" name="in_coef_specificites_techniques_4" value="1" <?php if($product['in_coef_specificites_techniques_4'] >= 1){echo 'checked="checked"';} ?> > Oui <input type="radio" name="in_coef_specificites_techniques_4" value="-1"<?php if($product['in_coef_specificites_techniques_4'] == -1){echo 'checked="checked"';} ?>>  Non &nbsp;&nbsp;&nbsp;Renonciation à recours contre l'état</td></tr>
                                                            <tr><td><input type="radio" name="in_coef_specificites_techniques_5" value="1" <?php if($product['in_coef_specificites_techniques_5'] >= 1){echo 'checked="checked"';} ?> > Oui <input type="radio" name="in_coef_specificites_techniques_5" value="-1"<?php if($product['in_coef_specificites_techniques_5'] == -1){echo 'checked="checked"';} ?>>  Non &nbsp;&nbsp;&nbsp;Renonciation à recours prop / locataire</td></tr>
                                                            <tr><td><input type="radio" name="in_coef_specificites_techniques_6" value="1" <?php if($product['in_coef_specificites_techniques_6'] >= 1){echo 'checked="checked"';} ?> > Oui <input type="radio" name="in_coef_specificites_techniques_6" value="-1"<?php if($product['in_coef_specificites_techniques_6'] == -1){echo 'checked="checked"';} ?>>  Non &nbsp;&nbsp;&nbsp;Doublement des limites en tempête</td></tr>
                                                            <tr><td><input type="radio" name="in_etat_defautprotection" value="1" <?php if($product['in_etat_defautprotection'] >= 1){echo 'checked="checked"';} ?>> Oui <input type="radio" name="in_etat_defautprotection" value="-1" <?php if($product['in_etat_defautprotection'] == -1){echo 'checked="checked"';} ?>> Non &nbsp;&nbsp;&nbsp;Défaut de protection</td></tr>

                                                            <tr bgcolor="#C0C0C0"><td valign="middle"><b>OPTIONS</b></td></tr>
                                                            <tr><td><input type="radio" name="in_nombre_baux" value="1" <?php if($product['in_nombre_baux'] >= 1){echo 'checked="checked"';} ?> > Oui <input type="radio" name="in_nombre_baux" value="-1"<?php if($product['in_nombre_baux'] == -1){echo 'checked="checked"';} ?>>  Non &nbsp;&nbsp;&nbsp;Protection juridique étendu</td></tr>
                                                            <tr><td><input type="radio" name="in_coef_minorations_possibles_0" value="1" <?php if($product['in_coef_minorations_possibles_0'] >= 1){echo 'checked="checked"';} ?> > Oui <input type="radio" name="in_coef_minorations_possibles_0" value="-1"<?php if($product['in_coef_minorations_possibles_0'] == -1){echo 'checked="checked"';} ?>>  Non &nbsp;&nbsp;&nbsp;Suppression GARANTIE VOL</td></tr>
                                                            <tr><td><input type="radio" name="in_coef_minorations_possibles_1" value="1" <?php if($product['in_coef_minorations_possibles_1'] >= 1){echo 'checked="checked"';} ?> > Oui <input type="radio" name="in_coef_minorations_possibles_1" value="-1"<?php if($product['in_coef_minorations_possibles_1'] == -1){echo 'checked="checked"';} ?>>  Non &nbsp;&nbsp;&nbsp;Suppression GARANTIE DDE</td></tr>
                                                            <tr><td><input type="radio" name="in_coef_minorations_possibles_2" value="1" <?php if($product['in_coef_minorations_possibles_2'] >= 1){echo 'checked="checked"';} ?> > Oui <input type="radio" name="in_coef_minorations_possibles_2" value="-1"<?php if($product['in_coef_minorations_possibles_2'] == -1){echo 'checked="checked"';} ?>>  Non &nbsp;&nbsp;&nbsp;Suppression GARANTIE Bris de glace</td></tr>
                                                        </table>
                                                    </td><td valign="top">
                                                        <table class="tarificateur">
                                                            <tr bgcolor="#C0C0C0"><td valign="middle" width="210" style="visibility: hidden"><b>MARGE</b></td></tr><tr><td  style="visibility: hidden">Marge appliquée : <select name="in_marge"><option value="1.3">+ 20%</option></select></td></tr><tr><td valign="middle">&nbsp;</td><td><td></tr><tr bgcolor="#C0C0C0"><td valign="middle"><b>TARIFS ET CLAUSES</b></td></tr><tr><td width="200" height="100%"><div id="result"></div></td></tr>
                                                        </table>
                                                    </td></tr>
                                                    </td></tr>
                                            </table>
                                        </td></tr>
                                </table>

                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection