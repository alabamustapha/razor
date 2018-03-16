@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Les produits</div>

                    <div class="panel-body text-center">
                        <a href="{{ url('tarificateurbatiment') }}" style="background-color:#d08639!important; border-color: #d08639!important;margin-bottom:5px;" class="btn btn-primary">Tarificateur Bâtiment inférieur à 1500m2</a>
                        <a href="{{ url('tarificateurgroupama/nbr_sinistre') }}" style="background-color:#d08639!important; border-color: #d08639!important;margin-bottom:5px;" class="btn btn-primary">Tarificateur Bâtiment supérieur à 1500m2</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Mes devis</div>
                            <div class="panel-body">
                                <ul>
                                    @foreach($devis as $list_devis)


                                        <li>
                                            <b>Devis {{App\Models\Home::type_to_label($list_devis->type_product)}} n° {{$list_devis->id}} {{$list_devis->customer_nom}} <a href="{{ route('details', $list_devis->id) }}"><i class="fa fa-cog" aria-hidden="true"></i></a></b>
                                        </li>

                                        {{date('d-m-Y', strtotime($list_devis->date_creation))}} - {{number_format($list_devis->tarificateur_amount, 2)}} € - {{App\Models\Home::display_last_status($list_devis->status)}}
                                    @endforeach
                                </ul>
                                <h4>Mes Anciens Devis</h4>
                                <ul>
                                    @foreach($old_devis as $list_old_devis)


                                        <li>
                                            <b>Devis {{App\Models\Home::type_to_label($list_old_devis->type_product)}} n° {{$list_old_devis->id}} {{$list_old_devis->customer_nom}} <a href="{{ route('old_details', $list_old_devis->id) }}"><i class="fa fa-cog" aria-hidden="true"></i></a></b>
                                        </li>

                                        {{date('d-m-Y', strtotime($list_old_devis->date_creation))}} - {{number_format($list_old_devis->tarificateur_amount, 2)}} € - {{App\Models\Home::display_last_status($list_old_devis->status)}}
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- end panel default -->
                    </div>
                    <!-- end col-6 -->




                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Mes Contrats</div>
                            <div class="pane-body">
                                <ul>
                                    @foreach($devis as $list_devis)
                                        @if( App\Models\TarificateurBatiment::search_status($list_devis->status, "30-" ))
                                            <li>
                                                <b>Contrat {{App\Models\Home::type_to_label($list_devis->type_product)}} n° {{App\Models\Home::display_id_contrat($list_devis->id_contrat)}} {{$list_devis->customer_nom}} <a href="{{ route('details', $list_devis->id) }}"><i class="fa fa-cog" aria-hidden="true"></i></a></b>
                                            </li>

                                            {{date('d-m-Y', strtotime($list_devis->date_creation))}} - {{number_format($list_devis->tarificateur_amount, 2)}} € - {{App\Models\Home::display_last_status($list_devis->status)}}
                                            @endif
                                    @endforeach
                                </ul>
                                <h4>Mes Anciens Contrats</h4>
                                <ul>
                                    @foreach($old_devis as $list_old_devis)
                                        @if( App\Models\TarificateurBatiment::search_status($list_old_devis->status, "30-" ))
                                            <li>
                                                <b>Contrat {{App\Models\Home::type_to_label($list_old_devis->type_product)}} n° {{App\Models\Home::display_id_contrat($list_old_devis->id_contrat)}} {{$list_old_devis->customer_nom}} <a href="{{ route('old_details', $list_old_devis->id) }}"><i class="fa fa-cog" aria-hidden="true"></i></a></b>
                                            </li>
                                            {{date('d-m-Y', strtotime($list_old_devis->date_creation))}} - {{number_format($list_old_devis->tarificateur_amount, 2)}} € - {{App\Models\Home::display_last_status($list_old_devis->status)}}
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <!-- end panel body -->
                        </div>
                        <!-- end panel -->
                    </div>
                    <!-- end col-6 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end col-10 -->
        </div>
        <!-- end outer row -->
    </div>
    <!-- end container -->
@endsection
