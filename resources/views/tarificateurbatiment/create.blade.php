@extends('layouts.app')

@section('content')

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("input").keypress(function () {


                $.ajax({
                    url: '{{ URL::action('TarificateurBatimentController@result_tarif_batiment') }}',
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
                    } else if (tarificateur_batiment.in_nombre_surface.value_in_nombre_surface > 1500 ||  (parseInt(tarificateur_batiment.in_nombre_surface.value_in_nombre_surface)!=tarificateur_batiment.in_nombre_surface.value_in_nombre_surface))
                    {
                        tarificateur_batiment.in_nombre_surface.value_in_nombre_surface = 0;
                        alert("La surface développée ne peut être supérieure à 1500 m2.");
                    } else {}

                    $.ajax({
                        url: '{{ URL::action('TarificateurBatimentController@result_tarif_batiment') }}',
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(reponse) {
                            $('div#result').html(reponse);
                        }
                    });
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

                        <form id="tarificateur_batiment" action="">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <center>

                                <table width="900">
                                    <tr><td valign="top">
                                            <table width="900">
                                                <tr><td valign="top">
                                                        <table class="tarificateur" cellspacing="0" cellpadding="1">
                                                            <tr bgcolor="#C0C0C0"><td valign="middle">&nbsp;+ <b>CONTEXTE CLIENT</b></td><td><td></tr>
                                                            <tr><td valign="middle">Nombre de sinistres / 36 mois</td><td><input type="text" name="in_nombre_sinistres" value="{{$value_in_nombre_sinistre}}" placeholder="1" size="3"> sinistre(s)</td></tr>
                                                            <tr><td valign="middle">Surface développée</td><td><input type="text" name="in_nombre_surface" value="{{$value_in_nombre_surface}}" size="3"> m2</td></tr>
                                                            <tr><td valign="middle">Département</td><td><?php echo App\Models\TarificateurBatiment::display_select($coef_zone, "in_coef_zone") ?></td></tr>
                                                            <tr><td valign="middle">Aggravation occupation</td><td><?php echo App\Models\TarificateurBatiment::display_select($coef_aggravation_occupation, "in_coef_aggravation_occupation")?></td></tr>
                                                            {{-- Ne pas decommenté           <tr><td valign="middle">Catégorie batiment</td><td>'.display_select($coef_categorie_batiment, "in_coef_categorie_batiment").'</td></tr> --}}
                                                            <tr><td valign="middle">Année de construction</td><td><?php echo App\Models\TarificateurBatiment::display_select($coef_annee_construction, "in_coef_annee_construction")?></td></tr>
                                                            <tr><td valign="middle">Antécédents</td><td><?php echo App\Models\TarificateurBatiment::display_select($coef_antecedents, "in_coef_antecedents") ?> <td></tr>
                                                        </table>
                                                    </td><td valign="top">
                                                        <table class="tarificateur" cellspacing="0" cellpadding="1">
                                                            <tr bgcolor="#C0C0C0"><td valign="middle"><b>SPECIFICITES TECHNIQUES</b></td></tr>
                                                            <tr><td><?php echo App\Models\TarificateurBatiment::display_radio($coef_specificites_techniques, "in_coef_specificites_techniques")?></td></tr>
                                                            <tr><td><input type="radio" name="in_etat_defautprotection" value="1"> Oui <input type="radio" name="in_etat_defautprotection" value="-1" checked> Non &nbsp;&nbsp;&nbsp;Défaut de protection</td></tr>
                                                            <tr><td valign="middle">&nbsp;</td></tr>
                                                            <tr bgcolor="#C0C0C0"><td valign="middle"><b>OPTIONS</b></td></tr>
                                                            <tr><td><input type="radio" name="in_nombre_baux" value="1"> Oui <input type="radio" name="in_nombre_baux" value="-1" checked> Non &nbsp;&nbsp;&nbsp;Protection juridique étendu</td></tr>

                                                            <tr><td><?php echo App\Models\TarificateurBatiment::display_radio($coef_minorations_possibles, "in_coef_minorations_possibles")?></td></tr>
                                                            {{-- Ne pas decommenté               <tr><td>'.display_radio($protection_juridique_etendu, "in_protection_juridique_etendu").'</td></tr>'; --}}
                                                        </table>
                                                    </td><td valign="top">
                                                        <table class="tarificateur">
                                                            <tr bgcolor="#C0C0C0"><td valign="middle" width="210" style="visibility: hidden"><b>MARGE</b></td></tr><tr><td  style="visibility: hidden">Marge appliquée : <select name="in_marge"><option value="1.3">+ 20%</option></select></td></tr><tr><td valign="middle">&nbsp;</td><td><td></tr><tr bgcolor="#C0C0C0"><td valign="middle"><b>TARIFS ET CLAUSES</b></td></tr><tr><td width="200" height="100%"><div id="result"></div></td></tr>
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