@extends('layouts.app')
@section('content')

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $.ajax({
                url: '{{ URL::action('TarificateurGroupamaController@test_result') }}',
                type: 'POST',
                data: $('#tarificateur_groupama').serialize(),
                success: function(reponse) {
                    console.log(reponse)
                    $('div#result').html(reponse);
                }
            });

            $('#tarificateur_groupama').change(function() {

                $.ajax({
                    url: '{{ URL::action('TarificateurGroupamaController@test_result') }}',
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
                        <form id="tarificateur_groupama" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="container">
                                <div class="row">

                                    @if($value_in_nbr_sinistre >= 10)
                                        <div class="col-md-8">
                                            <label>Nombre de sinistres trop élévé !</label>
                                            <a href="{{url('tarificateurgroupama/nbr_sinistre')}}">Retour</a>
                                        </div>
                                        @else
                                        <div class="col-md-4">
                                            <label>Surface</label><input type="text" name="in_nombre_surface" value="{{$value_in_nbr_surface}}">
                                            <br>
                                            <label>Sinistre(s)</label><input type="text" name="in_nombre_sinistres" disabled="disabled" value="{{$value_in_nbr_sinistre}}"><br>
                                            @if($value_in_nbr_sinistre == 0)

                                            @elseif($value_in_nbr_sinistre == 1)
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input type="text" name="sinistre_1" placeholder="cout du sinistre €">

                                            @elseif($value_in_nbr_sinistre == 2)
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input type="text" name="sinistre_1" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_1") ?><input type="text" name="sinistre_2" placeholder="cout du sinistre €">

                                            @elseif($value_in_nbr_sinistre == 3)
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input type="text" name="sinistre_1" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_1") ?><input type="text" name="sinistre_2" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_2") ?><input type="text" name="sinistre_3" placeholder="cout du sinistre €">

                                            @elseif($value_in_nbr_sinistre == 4)
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input type="text" name="sinistre_1" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_1") ?><input type="text" name="sinistre_2" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_2") ?><input type="text" name="sinistre_3" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_3") ?><input type="text" name="sinistre_4" placeholder="cout du sinistre €">


                                            @elseif($value_in_nbr_sinistre == 5)
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input type="text" name="sinistre_1" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_1") ?><input type="text" name="sinistre_2" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_2") ?><input type="text" name="sinistre_3" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_3") ?><input type="text" name="sinistre_4" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_4") ?><input type="text" name="sinistre_5" placeholder="cout du sinistre €">

                                            @elseif($value_in_nbr_sinistre == 6)
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input type="text" name="sinistre_1" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_1") ?><input type="text" name="sinistre_2" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_2") ?><input type="text" name="sinistre_3" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_3") ?><input type="text" name="sinistre_4" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_4") ?><input type="text" name="sinistre_5" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_5") ?><input type="text" name="sinistre_6" placeholder="cout du sinistre €">

                                            @elseif($value_in_nbr_sinistre == 7)

                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input type="text" name="sinistre_1" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_1") ?><input type="text" name="sinistre_2" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_2") ?><input type="text" name="sinistre_3" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_3") ?><input type="text" name="sinistre_4" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_4") ?><input type="text" name="sinistre_5" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_5") ?><input type="text" name="sinistre_6" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_6") ?><input type="text" name="sinistre_7" placeholder="cout du sinistre €">

                                            @elseif($value_in_nbr_sinistre == 8)

                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input type="text" name="sinistre_1" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_1") ?><input type="text" name="sinistre_2" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_2") ?><input type="text" name="sinistre_3" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_3") ?><input type="text" name="sinistre_4" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_4") ?><input type="text" name="sinistre_5" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_5") ?><input type="text" name="sinistre_6" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_6") ?><input type="text" name="sinistre_7" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_7") ?><input type="text" name="sinistre_8" placeholder="cout du sinistre €">

                                            @elseif($value_in_nbr_sinistre == 9)

                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_0") ?><input type="text" name="sinistre_1" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_1") ?><input type="text" name="sinistre_2" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_2") ?><input type="text" name="sinistre_3" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_3") ?><input type="text" name="sinistre_4" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_4") ?><input type="text" name="sinistre_5" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_5") ?><input type="text" name="sinistre_6" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_6") ?><input type="text" name="sinistre_7" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_7") ?><input type="text" name="sinistre_8" placeholder="cout du sinistre €">
                                                <br>
                                                <?php echo App\Models\TarificateurGroupama::display_select($liste_sini, "in_liste_sini_8") ?><input type="text" name="sinistre_9" placeholder="cout du sinistre €">
                                            @endif
                                            <br>
                                            <?php echo App\Models\TarificateurGroupama::display_select($in_zone, "in_zone") ?>
                                            <br>
                                            <?php echo App\Models\TarificateurGroupama::display_select($coef_annee_construction, "coef_annee_construction") ?>

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
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
