@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Dossier sur devis n°{{$tarif_bat->id}} {{$tarif_bat->customer_nom}}</h3></div>
                    <div class="panel-body">
                        <p>Les étapes suivants ont été passées et historisées sur ce dossier :</p>

                        <?php echo App\Models\TarificateurBatiment::display_all_status($tarif_bat->status)?>

                        <br>
                        <p>Les documents disponibles constitutifs du dossier :</p>
                        <ul>
                            @if($tarif_bat->type_product == 4)
                                <li><a class="btn-orange-a" target="_blank" href="{{url('devis_bat_groupama?id='.$tarif_bat->id)}}">Télécharger le devis</a></li>

                            @else

                                <li><a class="btn-orange-a" target="_blank" href="{{url('devis_bat?id='.$tarif_bat->id)}}">Télécharger le devis</a></li>

                            @endif
                            @if(App\Models\TarificateurBatiment::search_status($tarif_bat->status, "30-"))
                                @else
                                <li><a class="btn-orange-a" target="_blank" href="{{ route('modif_batiment_step_1',$tarif_bat->id) }}">Modifier le devis</a></li>
                            @endif
                        </ul>
                        <div class="text-center"><a class="btn-orange-a" href="{{url('/home')}}">Retour</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection