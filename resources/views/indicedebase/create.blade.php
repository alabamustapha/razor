@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Crée un indice</div>
                    <div class="panel-body">


                        {!! Form::open(array(
                        'route' => 'indicedebase.store',
                         'method' => 'POST')) !!}

                        {!! Form::label('indice', 'Indice') !!}
                        {!! Form::text('indice', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Indice']) !!}

                        {!! Form::label('valeur', 'Valeur') !!}
                        {!! Form::text('valeur', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Valeur de l\'indice de base']) !!}


                        {!! Form::submit('Ajouter',
                        ['class' => 'btn btn-group-justified']) !!}

                        <style>.btn-group-justified{background-color: lightsteelblue}</style>


                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection