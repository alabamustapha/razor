@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading title_espace_pro text-center">
                        ESPACE PROFESSIONNELS
                    </div>

                    <div class="panel-body">

                        <div>
                            <label><strong>Activia products</strong> - Etape 2/4</label>
                        </div>

                        <form class="form-horizontal" action="{{ url('activia/step3') }}" method="post" name="form_proposant_s2">
                            <div class="row">
                                <div class="col-md-6">
                                    
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


                                        <label style="display: block;background:#C0C0C0;color:#000;">LE PROPOSANT</label>                                     
                                        <div class="form-group">
                                            <label for="in_customer_sigle" class="col-md-4 control-label">Sigle</label> 
                                            <div class="col-md-6">
                                                <select name="in_customer_sigle" class="form-control">
                                                 <option value="M.">M.</option>
                                                        <option value="Mme">Mme</option>
                                                        <option value="Mlle">Mlle</option>
                                                        <option value="Eurl">Eurl</option>
                                                        <option value="Sarl">Sarl</option>
                                                        <option value="SA">SA</option>
                                                        <option value="Sté">Sté</option>
                                                        <option value="SCI">SCI</option>
                                                        <option value="Copro">Copro</option>
                                                        <option value="Syndic">Syndic</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="in_customer_nom" class="col-md-4 control-label">Nom</label>
                                            <div class="col-md-6">
                                                <input name="in_customer_nom" value="" class="form-control" type="text" size="33">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="in_customer_prenom" class="col-md-4 control-label">Prénom</label>
                                            <div class="col-md-6">
                                                <input name="in_customer_prenom" value="" class="form-control" type="text" size="33">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="in_customer_adresse" class="col-md-4 control-label">Adresse</label>
                                            <div class="col-md-6">
                                                <textarea name="in_customer_adresse" cols="40" rows="5" class="form-control"></textarea>  
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="in_customer_codepostal" class="col-md-4 control-label">Code postal</label>
                                            <div class="col-md-6">
                                                <input name="in_customer_codepostal" value="" class="form-control" type="text" maxlength="5" size="4">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="in_customer_ville" class="col-md-4 control-label">Ville</label>
                                            <div class="col-md-6">
                                                <input name="in_customer_ville" value="" class="form-control" type="text" size="33">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="in_customer_datedenaissance" class="col-md-4 control-label">Date de naissance</label>
                                            <div class="col-md-6">
                                                <input name="in_customer_datedenaissance" value="" class="form-control" type="text" size="33">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="in_customer_telephone" class="col-md-4 control-label">Téléphone</label>
                                            <div class="col-md-6">
                                                <input name="in_customer_telephone" value="" class="form-control" type="text" size="33">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="in_customer_fax" class="col-md-4 control-label">Fax</label>
                                            <div class="col-md-6">
                                                <input name="in_customer_fax" value="" class="form-control" type="text" size="33">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="in_customer_courriel" class="col-md-4 control-label">Courriel</label>
                                            <div class="col-md-6">
                                                <input name="in_customer_courriel" value="" class="form-control" type="text" size="33">
                                            </div>
                                        </div>
                                </div>

                                <div class="col-md-6">
                                    <label style="display: block;background:#C0C0C0;color:#000;">CARACTERISTIQUES DU RISQUE</label>

                                     <div class="form-group">
                                        <label for="in_risk_adresse" class="col-md-4 control-label">Adresse</label>
                                        <div class="col-md-6">
                                            <textarea name="in_risk_adresse" cols="40" rows="5" class="form-control"></textarea>  
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="in_risk_codepostal" class="col-md-4 control-label">Code postal</label>
                                        <div class="col-md-6">
                                            <input name="in_risk_codepostal" value="" class="form-control" type="text" maxlength="5" size="4">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="in_risk_ville" class="col-md-4 control-label">Ville</label>
                                        <div class="col-md-6">
                                            <input name="in_risk_ville" value="" class="form-control" type="text" size="33">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="in_risk_occupant" class="col-md-4 control-label">Occupant</label>
                                        <div class="col-md-6">

                                            Oui <input type="radio" name="in_risk_occupant" value="1" checked>
                                            Non <input type="radio" name="in_risk_occupant" value="0">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="in_risk_naturerisque" class="col-md-4 control-label">Nature du risque</label> 
                                        <div class="col-md-6">
                                            <select name="in_risk_naturerisque" class="form-control">
                                                <option value="Maison particulière">Maison particulière</option>
                                                <option value="Immeuble collectif">Immeuble collectif</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="in_risk_residence" class="col-md-4 control-label">Résidence</label>
                                        <div class="col-md-6">
                                            <select name="in_risk_residence" class="form-control">
                                               <option value="Immeuble de rapport">Immeuble de rapport
                                               </option>
                                                <option value="Coproprieté">Coproprieté
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <div class="form_field">
                                            <a href="{{ url('home') }}">Annuler</a> - <button class="btn-orange-a" style="border: none!important; background-color: transparent" type="submit">Aller à l'étape 3</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                            
                        


                      

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection