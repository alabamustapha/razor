@extends('layouts.report')

@section('styles')
<style>
    .html5buttons{
        margin-bottom: 20px;
    }
    td, th {
    white-space: nowrap;
    overflow: hidden;
    }

    table#report>tbody>tr:nth-of-type(odd){
        background-color: #fff;
    }
</style>
@endsection
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div style="margin: 0 auto; width: 100%;"> 
                <div class="table-responsive">
                    <table id="report" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                                <th>{{"Type d'opération"}}</th>
                                <th>{{"Numéro de client"}}</th>
                                <th>{{"Nom"}}</th>
                                <th>{{"Prénom"}}</th>
                                <th>{{"Numéro de police courtier"}}</th>
                                <th>{{"numéro de police CNAM"}}</th>
                                <th>{{"Produit"}}</th>
                                <th>{{"Capital assuré"}}</th>
                                <th>{{"Périodicité"}}</th>
                                <th>{{"Début d'effet"}}</th>
                                <th>{{"Fin d'effet"}}</th>
                                <th>{{"Code risque"}}</th>
                                <th>{{"Motif résiliation"}}</th>
                                <th>{{"TTC compagnie"}}</th>
                                <th>{{"Commission"}}</th>
                                <th>{{"Incendie"}}</th>
                                <th>{{"Incendie taux %"}}</th>
                                <th>{{"Incendie taxe"}}</th>
                                <th>{{"TOC"}}</th>
                                <th>{{"TOC taux %"}}</th>
                                <th>{{"TOC taxe"}}</th>
                                <th>{{"Dom elec"}}</th>
                                <th>{{"Dom elec taux %"}}</th>
                                <th>{{"Dom elect taxe"}}</th>
                                <th>{{"Renonciation recours"}}</th>
                                <th>{{"Renonciation recours taux %"}}</th>
                                <th>{{"Renonciation taxe"}}</th>
                                <th>{{"Vol"}}</th>
                                <th>{{"Vol taux %"}}</th>
                                <th>{{"Vol taxe"}}</th>
                                <th>{{"RC"}}</th>
                                <th>{{"RC taux %"}}</th>
                                <th>{{"RC taxe"}}</th>
                                <th>{{"Vandalisme"}}</th>
                                <th>{{"Vandalisme taux %"}}</th>
                                <th>{{"Vandalisme taxe"}}</th>
                                <th>{{"Perte d'exploitation"}}</th>
                                <th>{{"Perte d'exploitation taux %"}}</th>
                                <th>{{"Perte d'exploitation taxe"}}</th>
                                <th>{{"Bris de glace"}}</th>
                                <th>{{"Bris de glace taux %"}}</th>
                                <th>{{"Bris de glace taxe"}}</th>
                                <th>{{"Dégat des eaux"}}</th>
                                <th>{{"Dégat des eaux %"}}</th>
                                <th>{{"Dégat des eaux taxe"}}</th>
                                <th>{{"BDM"}}</th>
                                <th>{{"BDM taux %"}}</th>
                                <th>{{"BDM taxe"}}</th>
                                <th>{{"Cat Nat"}}</th>
                                <th>{{"Cat Nat taux %"}}</th>
                                <th>{{"Cat Nat taxe"}}</th>
                                <th>{{"Cat Tech"}}</th>
                                <th>{{"Cat Tech taux %"}}</th>
                                <th>{{"Cat Tech taxe"}}</th>
                                <th>{{"Attentat"}}</th>
                                <th>{{"Attentat taux %"}}</th>
                                <th>{{"Attentat taxe"}}</th>
                                <th>{{"Total Prime TTC"}}</th>
                                <th>{{"Total taxe"}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($tarificateur_batiments_records as $tarificateur_batiments)
                            @foreach($tarificateur_batiments as $tarificateur_batiment)
                            
                            <tr>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>{{ $tarificateur_batiment->customer_nom }}</td>
                                <td>{{ $tarificateur_batiment->data_proposant['in_customer_prenom'] }}</td>    
                                <td>{{ display_id_contrat($tarificateur_batiment->id_contrat) }}</td>     
                                <td>{{ 'N/A' }}</td>     
                                <td>{{ 'Assurance ' . type_to_label($tarificateur_batiment->type_product)." ".strtolower($tarificateur_batiment->formule) }}</td>   
                                <td>
                                @if ($tarificateur_batiment->type_product == 3)
                                    
                                    @if (preg_match('/ECO/',$tarificateur_batiment->formule))  
                                        {{ format_tarif(unserialize($tarificateur_batiment->data_product)['result_eco']['mobilier']) }}  
                                    @elseif (preg_match('/CONFORT/',$tarificateur_batiment->formule)) 
                                       {{ format_tarif(unserialize($tarificateur_batiment->data_product)['result_confort']['mobilier']) }} 
                                    @elseif(preg_match('/PRESTIGE/',$tarificateur_batiment->formule)) 
                                    
                                    {{ format_tarif(unserialize($tarificateur_batiment->data_product)['result_prestige']['mobilier']) }}
                                    
                                    @elseif (preg_match('/PNO/',$tarificateur_batiment->formule)) 
                                        {{ format_tarif(0.00) }}
                                    @endif

                                @else 
                                    {{ format_tarif(0.00) }}
                                @endif

                                </td>
                                <td>{{ $tarificateur_batiment->periodicity }}</td>
                                <td>{{ date("d/m/Y à 00:00", $tarificateur_batiment->date_contract) }}</td>
                                <td>{{ date("d/m/Y à 00:00", strtotime("+1 year",$tarificateur_batiment->date_contract)) }}</td>
                                <td>{{ 'N/A' }}</td>
                                <td>{{ 'N/A' }}</td>
                                <td>{{ format_tarif($tarificateur_batiment->customer_amount *0.6) }}</td>    
                                <td>{{ 'N/A'}}</td>
        					    <td>{{ format_tarif($tarificateur_batiment->calculations['cotisation_incendie_ht']) }}</td>
                                <td>{{ "30%" }}</td>
                                <td>{{ format_tarif($tarificateur_batiment->calculations['cotisation_incendie_taxe']) }}</td>
                                <td>{{ format_tarif($tarificateur_batiment->calculations['repartition_tgn_ht']) }}</td>
                                <td>{{ "9%" }}</td>
                                <td>{{ format_tarif($tarificateur_batiment->calculations['repartition_tgn_taxe']) }}</td>
                                <td>{{ format_tarif($tarificateur_batiment->calculations['repartition_dommageselectriques_ht']) }}</td>
                                <td>{{ "9%" }}</td>
                                <td>{{ format_tarif($tarificateur_batiment->calculations['repartition_dommageselectriques_taxe']) }}</td>
                                <td>{{ 'N/A'}}</td>
                                <td>{{ 'N/A'}}</td>
                                <td>{{ 'N/A'}}</td>
                                <td>{{ format_tarif($tarificateur_batiment->calculations['repartition_vol_ht']) }}</td>
                                <td>{{ "9%" }}</td>
                                <td>{{ format_tarif($tarificateur_batiment->calculations['repartition_vol_taxe']) }}</td>
                                <td>{{ format_tarif($tarificateur_batiment->calculations['repartition_rc_ht']) }}</td>
                                <td>
                                    @if($tarificateur_batiment->formule == "OPTION PROPRIETAIRE NON OCCUPANT")
                                        {{ "5%" }}
                                    @else	
                                        {{ "21%" }}
                                    @endif    
                                </td>
                                <td>{{ format_tarif($tarificateur_batiment->calculations['repartition_rc_taxe']) }}</td>
                                <td>{{ 'N/A'}}</td>
                                <td>{{ 'N/A'}}</td>
                                <td>{{ 'N/A'}}</td>
                                <td>{{ 'N/A'}}</td>
                                <td>{{ 'N/A'}}</td>
                                <td>{{ 'N/A'}}</td>
                                <td>{{ format_tarif($tarificateur_batiment->calculations['repartition_brisdeglaces_ht']) }}</td>
                                <td>{{"9%"}}</td>
                                <td>{{ format_tarif($tarificateur_batiment->calculations['repartition_brisdeglaces_taxe']) }}</td>    
                                <td>{{ format_tarif($tarificateur_batiment->calculations['repartition_degatsdeseaux_ht']) }}</td>    
                                <td>{{"9%"}}</td>
                                <td>{{ format_tarif($tarificateur_batiment->calculations['repartition_degatsdeseaux_taxe']) }}</td>    
                                <td>{{ 'N/A'}}</td>
                                <td>{{ 'N/A'}}</td>
                                <td>{{ 'N/A'}}</td>
                                <td>{{ format_tarif($tarificateur_batiment->calculations['cotisation_cn_ht']) }}</td>    
                                <td>{{"9%"}}</td>
                                <td>{{ format_tarif($tarificateur_batiment->calculations['cotisation_cn_taxe']) }}</td>    
                                <td>{{ format_tarif($tarificateur_batiment->calculations['cotisation_risques_technologiques_ht']) }}</td>    
                                <td>{{"9%"}}</td>    
                                <td>{{ format_tarif($tarificateur_batiment->calculations['cotisation_risques_technologiques_taxe']) }}</td>    
                                <td>{{ format_tarif($tarificateur_batiment->calculations['cotisation_attentats_ht']) }}</td>    
                                <td>{{"9%"}}</td>    
                                <td>{{ format_tarif($tarificateur_batiment->calculations['cotisation_attentats_taxe']) }}</td>    
                                <td>{{ format_tarif($tarificateur_batiment->customer_amount *0.6 - $tarificateur_batiment->calculations['taxes_annuelles']) }}</td>    
                                <td>{{ format_tarif($tarificateur_batiment->calculations['taxes_annuelles']) }}</td>    
                                
                            </tr>
                            @endforeach
                        @endforeach   

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
     
        $('table#report').DataTable( {
                
                "scrollX": true,
                
                pageLength: 10,
                
                dom: '<"html5buttons"B>lTfgitp',
                
                buttons: [
                    {extend: 'excel', title: 'Report', text: 'Téléchager l\'extraction',},
                ],
                language:{
                    "decimal":        ",",
                    "emptyTable":     "No data available in table",
                    "info":           "affichage _START_ to _END_ of _TOTAL_ entrées",
                    "infoEmpty":      "affichage 0 to 0 of 0 entrées",
                    "infoFiltered":   "(filtered from _MAX_ total entrées)",
                    "infoPostFix":    "",
                    "thousands":      ".",
                    "lengthMenu":     "Afficher _MENU_ entrées",
                    "loadingRecords": "chargement...",
                    "processing":     "En traitement...",
                    "search":         "Rechercher:",
                    "zeroRecords":    "Aucun enregistrements correspondants trouvés",
                    "paginate": {
                        "first":      "Premier",
                        "last":       "dernier",
                        "next":       "Suivant",
                        "previous":   "Précédent"
                    },
                    "aria": {
                        "sortAscending":  ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    }
                }    
        });

        
    });
 </script>   
@endsection