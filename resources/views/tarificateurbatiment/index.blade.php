@extends('layouts.admin')

@section('content')
    {{--
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){

            load_data();

            function load_data(query)
            {
                $.ajax({
                    url:"fetch.php",
                    method:"POST",
                    data:{query:query},
                    success:function(data)
                    {
                        $('#search_result').html(data);
                    }
                });
            }
            $('#search_text').keyup(function(){
                var search = $(this).val();
                if(search != '')
                {
                    load_data(search);
                }
                else
                {
                    load_data();
                }
            });
        });
    </script>--}}
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
               {{-- <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="search_text" id="search_text" class="form-control" placeholder="N° devis, Courtier, Date">
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit">Rechercher</button>
                                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Choix</button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Id</a></li>
                                        <li><a href="#">Courtier</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div id="search_result"></div>
                        </div>
                    </div>


                </div>--}}



                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Les devis et contrat</h3></div>
                    <div class="panel-body">
                        <h4>Gestion des devis et des contrats</h4>
                        <div class="table-responsive">
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
                                @foreach($devis as $devis_contrat)
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
                        </div>


                        {{ $devis->render() }}
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Les anciens devis et contrat</h3></div>
                    <div class="panel-body">
                        <h4>Gestion des devis et des contrats ancien tarificateur</h4>
                        <div class="table-responsive">
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
                                @foreach($old_devis as $old_devis_contrat)
                                    <tr>


                                        <td><a class="btn-orange-a" href="{{ route('oldeditioncontrat', $old_devis_contrat->id) }}">Consulter</a></td>
                                        <td>{{App\Models\TarificateurBatiment::type_to_label($old_devis_contrat->type_product)}}</td>
                                        <td>{{$old_devis_contrat->customer_nom }}</td>
                                        <td>{{date('d-m-Y', strtotime($old_devis_contrat->date_creation))}}</td>
                                        <td>{{App\Models\TarificateurBatiment::format_tarif($old_devis_contrat->tarificateur_amount)}}</td>
                                        <td>{{App\Models\TarificateurBatiment::format_tarif($old_devis_contrat->customer_amount)}}</td>
                                        <td>{{App\Models\TarificateurBatiment::format_tarif($old_devis_contrat->partner_amount * 0.90 )}}</td>
                                        <td>{{App\Models\TarificateurBatiment::format_tarif($old_devis_contrat->affiliate_amount)}}</td>
                                        <td>{{App\Models\TarificateurBatiment::format_tarif($old_devis_contrat->tarificateur_amount * 0.83 * 0.1 + $devis_contrat->partner_amount * 0.10)}}</td>
                                        <td>{{App\Models\TarificateurBatiment::display_last_status($old_devis_contrat->status)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>



                        {{ $old_devis->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
