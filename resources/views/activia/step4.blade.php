@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading title_espace_pro"><center>ESPACE PROFESSIONNELS</center></div>
                    <div class="panel-body">
                        <div>
                            <strong>Assurance batiment \ Activia</strong> - Etape 4/4
                        </div>
                        <div>
                            <p>Votre devis assurance batiment a été enregistré (référence #{{ $contrat }}). Vous pouvez télécharger le devis correspondant à votre client en cliquant sur le lien ci-dessous </p>
                        </div>
                        <div class="body_step3">
                            <a class="btn-orange-a" target="_blank" href="{{url('activia_pdf?id='.$contrat)}}">Télécharger le devis</a> - <a
                                    href="{{ url('/home') }}">Retour au menu</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection