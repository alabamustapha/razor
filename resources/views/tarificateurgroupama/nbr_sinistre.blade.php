@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Tarificateur batiment / Nombre de sinistre(s)</strong></div>
                <div class="panel-body">
                    <form class="form-horizontal" action="{{ url('tarificateurgroupama/nbr_sinistre_post') }}" method="post" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="in_nbr_sinistre" class="col-md-3 control-label" style="text-align: left;">Entrer un nombre de sinistre(s)</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" placeholder="Nombre de sinistre(s)" name="in_nbr_sinistre" value="{{$value_nbr_sinistres}}">
                            </div>
                        </div>
                        <button class="btn btn-orange" style="border: none!important; background-color: transparent" type="submit">Suivant</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

