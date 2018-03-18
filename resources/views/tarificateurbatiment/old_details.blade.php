@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Dossier sur devis n°{{$old_tarif_bat->id}} {{$old_tarif_bat->customer_nom}}</h3></div>
                    <div class="panel-body">
                        <p>Les étapes suivants ont été passées et historisées sur ce dossier :</p>

                        <?php echo App\Models\TarificateurBatiment::display_all_status($old_tarif_bat->status)?>

                        <br>
                        <p>Les documents disponibles constitutifs du dossier :</p>
                        <ul>
                            <li><a class="btn-orange-a" target="_blank" href="{{url('old_devis_bat?id='.$old_tarif_bat->id)}}">Télécharger le devis</a></li>
                        </ul>
                        <div class="text-center"><a class="btn-orange-a" href="{{url('/home')}}">Retour</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection