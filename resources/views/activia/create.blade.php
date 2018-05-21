@extends('layouts.app')

@section('content')

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
             $.ajax({
                    url: '{{ URL::action('ActiviaController@result') }}',
                    type: 'POST',
                    data: $('#activia_batiment').serialize(),
                    success: function(reponse) {
                        console.log(reponse)
                        $('div#result').html(reponse);
                    }
                });
                
            $("input, select").change(function () {


                $.ajax({
                    url: '{{ URL::action('ActiviaController@result') }}',
                    type: 'POST',
                    data: $('#activia_batiment').serialize(),
                    success: function(reponse) {
                        console.log(reponse)
                        $('div#result').html(reponse);
                    }
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
                                                    <option value="{{$ref+1}}" {{ $ref == 17 ? "selected" : "" }}>{{$profession}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="surface_of_property" class="col-md-4 control-label">Surface of property</label>
                                        <div class="col-md-8">
                                            <input name="surface_of_property" class="form-control" type="number" size="3" value="900"> m2
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="location" class="col-md-4 control-label">Location</label>
                                        <div class="col-md-8">
                                            <input name="location" class="form-control" type="number" placeholder="1" max="3" min="1" value="3"> 
                                        </div>
                                    </div>
                                   
                                    <div class="form-group">
                                        <label for="objets_de_miroiterie_extérieurs" class="col-md-4 control-label">Objets de miroiterie extérieurs </label>
                                        <div class="col-md-8">
                                            <input name="objets_de_miroiterie_extérieurs" class="form-control" type="number" value="200"> 
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="avec_franchise_de" class="col-md-4 control-label">Avec franchise de 1/3 x l'indice </label>
                                        <div class="col-md-8">
                                            <input name="avec_franchise_de" class="form-control" type="number" value="200"> 
                                        </div>
                                    </div> -->
                                   

                                   

                                </div>
                                <!-- end col-5 -->

                                <div class="col-md-5">

                                    <b>OPTIONS</b>

                                    <div class="form-group">
                                        
                                        <div class="col-md-10">

                                            @foreach($options as $index => $option)
                                            @if($loop->iteration == 1 || $loop->iteration == 16 || $loop->iteration == 17)
                                                <input type="hidden" name="activia_option_{{$index+1}}" value="1">
                                            @else
                                            <input type="radio" name="activia_option_{{$index+1}}" value="1" checked> Oui <input type="radio" name="activia_option_{{$index+1}}" value="-1"> Non {{ $option}} <br>
                                            @endif
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