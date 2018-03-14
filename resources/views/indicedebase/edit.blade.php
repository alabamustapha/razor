@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Modifier l'indice</h3></div>
                    <div class="panel-body">

                        {!! Form::model(
                          $indice_de_base,
                          array(
                        'route' => array('indicedebase.update', $indice_de_base->id),
                        'method' => 'PUT'))
                          !!}

                        <p>{{$indice_de_base->indice}}</p>

                        {!! Form::label('valeur', 'Valeur') !!}
                        {!! Form::text('valeur', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Valeur']) !!}
                        <br>

                        {!! Form::submit('Modifier',
                        ['class' => 'btn btn-group-justified btn-orange']) !!}

                        <style>.btn-group-justified{background-color: lightsteelblue}</style>


                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection