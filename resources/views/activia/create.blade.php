@extends('layouts.app')

@section('content')

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("input").keypress(function () {


                $.ajax({
                    url: '{{ URL::action('ActiviaController@result') }}',
                    type: 'POST',
                    data: $('#activia_batiment').serialize(),
                    success: function(reponse) {
                        console.log(reponse)
                        $('div#result').html(reponse);
                    }
                });

                $('#activia_batiment').change(function() {
                    // if (tarificateur_batiment.in_nombre_sinistres.value_in_nombre_sinistre < 0 ||  (parseInt(tarificateur_batiment.in_nombre_sinistres.value_in_nombre_sinistre) != tarificateur_batiment.in_nombre_sinistres.value_in_nombre_sinistre))
                    // {
                    //     tarificateur_batiment.in_nombre_sinistres.value_in_nombre_sinistre = 0;
                    //     alert("Le nombre de sinistre(s) est égal à 0 ou supérieur.");
                    // } else if (tarificateur_batiment.in_nombre_surface.value_in_nombre_surface > 1500 ||  (parseInt(tarificateur_batiment.in_nombre_surface.value_in_nombre_surface)!=tarificateur_batiment.in_nombre_surface.value_in_nombre_surface))
                    // {
                    //     tarificateur_batiment.in_nombre_surface.value_in_nombre_surface = 0;
                    //     alert("La surface développée ne peut être supérieure à 1500 m2.");
                    // } else {}

                    $.ajax({
                        url: '{{ URL::action('ActiviaController@result') }}',
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(reponse) {
                            console.log(reponse)
                            $('div#result').html(reponse);
                        }
                    });
                });
            });
        });

    </script>


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Activia products </strong> - Etape 1/4</div>
                    <div class="panel-body">

                        <form class="form-horizontal" id="activia_batiment" action="">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row">
                                <div class="col-md-5">

                                    <label style="background:#C0C0C0;color:#000;font-size:12px;width:100%;">
                                    &nbsp;+CONTEXTE CLIENT
                                    </label>

                                    <div class="form-group">
                                        <label for="profession" class="col-md-4 control-label">Profession</label>
                                        <div class="col-md-8">
                                            <select name="profession" id="profession" class="form-control">
                                                <option value="">select profession</option>
                                                @foreach($professions as $ref => $profession)
                                                    <option value="{{$ref+1}}">{{$profession}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="surface_of_property" class="col-md-4 control-label">Surface of property</label>
                                        <div class="col-md-8">
                                            <input name="surface_of_property" class="form-control" type="number" size="3"> m2
                                        </div>
                                    </div>
                                   
                                   
                                    <div class="form-group">
                                        <label for="location" class="col-md-4 control-label">Location</label>
                                        <div class="col-md-8">
                                            <input name="location" class="form-control" type="number" placeholder="1" max="3" min="1"> 
                                        </div>
                                    </div>

                                   

                                </div>
                                <!-- end col-5 -->

                                <div class="col-md-5">

                                    <b>OPTIONS</b>

                                    <div class="form-group">
                                        
                                        <div class="col-md-10">

                                            @foreach($options as $index => $option)
                                            <input type="radio" name="activia_option_{{$index+1}}" value="1"> Oui <input type="radio" name="activia_option_{{$index+1}}" value="-1" checked> Non {{ $option}} <br>
                                            @endforeach    
                                                
                                        </div>
                                    </div>

                                </div>
                                
                                <div class="col-md-2">

                                    <label style="background: #C0C0C0;color:#000;font-size:12px;width:100%;">TARIFS ET CLAUSES</label>

                                    <div id="result"></div>

                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection