@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Tarificateur batiment / Nombre de sinistre(s)</strong></div>
                <div class="panel-body">
                    <form action="{{ url('tarificateurgroupama/nbr_sinistre_post') }}" method="post" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label>Entrer un nombre de sinistre(s)</label>
                        <input type="text" placeholder="Nombre de sinistre(s)" name="in_nbr_sinistre" value="{{$value_nbr_sinistres}}">
                        <br>
                        <button class="btn-orange" style="border: none!important; background-color: transparent" type="submit">Suivant</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection