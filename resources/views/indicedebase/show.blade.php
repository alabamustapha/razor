@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading">{{ $indice_de_base->indice }}</div>
                    <div class="panel-body">

                        {{ $indice_de_base->valeur }}



                        <a href="{{ route('indicedebase.index') }}">Retour aux indices</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection