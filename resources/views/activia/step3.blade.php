@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading title_espace_pro"><center>ESPACE PROFESSIONNELS</center></div>
                    <div class="panel-body">
                        <div>
                            <strong>Activia</strong> - Etape 3/4
                        </div>
                        <div class="body_step3">
                            <a href="{{ url('activia/step2') }}">Revenir à l'étape 2</a> - <a class="btn-orange-a" href="{{ url('activia/step4') }}">Enregistrer et télécharger le devis</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection