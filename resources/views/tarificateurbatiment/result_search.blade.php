@extends('layouts.admin')
    @section('content')
    <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">Résultat de la recherche</div>
                            <div class="panel-body">
                                @if($devis == 1)
                                    <table class="table">
                                <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Type</th>
                                    <th>Nom client</th>
                                    <th>Date devis</th>
                                    <th>Tarif tarificateur</th>
                                    <th>Tarif client</th>
                                    <th>Prime brute fournisseur</th>
                                    <th>Commission affilié</th>
                                    <th>Commission prévidia</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($devis_search as $devis_contrat)
                                    <tr>


                                        <td><a class="btn-orange-a" href="{{ route('editioncontrat', $devis_contrat->id) }}">Consulter</a></td>
                                        <td>{{App\Models\TarificateurBatiment::type_to_label($devis_contrat->type_product)}}</td>
                                        <td>{{$devis_contrat->customer_nom }}</td>
                                        <td>{{date('d-m-Y', strtotime($devis_contrat->date_creation))}}</td>
                                        <td>{{App\Models\TarificateurBatiment::format_tarif($devis_contrat->tarificateur_amount)}}</td>
                                        <td>{{App\Models\TarificateurBatiment::format_tarif($devis_contrat->customer_amount)}}</td>
                                        <td>{{App\Models\TarificateurBatiment::format_tarif($devis_contrat->partner_amount * 0.90 )}}</td>
                                        <td>{{App\Models\TarificateurBatiment::format_tarif($devis_contrat->affiliate_amount)}}</td>
                                        <td>{{App\Models\TarificateurBatiment::format_tarif($devis_contrat->tarificateur_amount * 0.83 * 0.1 + $devis_contrat->partner_amount * 0.10)}}</td>
                                        <td>{{App\Models\TarificateurBatiment::display_last_status($devis_contrat->status)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @else
                            <table class="table">
                            <thead>
                            <tr>
                                <th>Action</th>
                                <th>Type</th>
                                <th>Nom client</th>
                                <th>Date devis</th>
                                <th>Tarif tarificateur</th>
                                <th>Tarif client</th>
                                <th>Prime brute fournisseur</th>
                                <th>Commission affilié</th>
                                <th>Commission prévidia</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($devis_search as $old_devis_contrat)
                                <tr>


                                    <td><a class="btn-orange-a" href="{{ route('oldeditioncontrat', $old_devis_contrat->id) }}">Consulter</a></td>
                                    <td>{{App\Models\TarificateurBatiment::type_to_label($old_devis_contrat->type_product)}}</td>
                                    <td>{{$old_devis_contrat->customer_nom }}</td>
                                    <td>{{date('d-m-Y', strtotime($old_devis_contrat->date_creation))}}</td>
                                    <td>{{App\Models\TarificateurBatiment::format_tarif($old_devis_contrat->tarificateur_amount)}}</td>
                                    <td>{{App\Models\TarificateurBatiment::format_tarif($old_devis_contrat->customer_amount)}}</td>
                                    <td>{{App\Models\TarificateurBatiment::format_tarif($old_devis_contrat->partner_amount * 0.90 )}}</td>
                                    <td>{{App\Models\TarificateurBatiment::format_tarif($old_devis_contrat->affiliate_amount)}}</td>
                                    <td>{{App\Models\TarificateurBatiment::format_tarif($old_devis_contrat->tarificateur_amount * 0.83 * 0.1 + $old_devis_contrat->partner_amount * 0.10)}}</td>
                                    <td>{{App\Models\TarificateurBatiment::display_last_status($old_devis_contrat->status)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection