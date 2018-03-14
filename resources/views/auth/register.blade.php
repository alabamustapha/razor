@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Inscription</div>
                    <div class="inscription_users">
                        <p><center>Devenez affilié de CORIM ASSURANCE en renseignant le fomumlaire ci-dessous</center></p>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ url('register') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Adresse email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Mot de passe</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirmation mot de passe</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('aff_civility') ? ' has-error' : '' }}">
                                <label for="aff_civility" class="col-md-4 control-label">Civilité</label>

                                <div class="col-md-6">
                                    <select name="aff_civility">
                                        <option value="0">Monsieur</option>
                                        <option value="1">Madame ou Mademoiselle</option>
                                    </select>
                                    @if ($errors->has('aff_civility'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('aff_civility') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('aff_fname') ? ' has-error' : '' }}">
                                <label for="aff_fname" class="col-md-4 control-label">Prénom</label>

                                <div class="col-md-6">
                                    <input id="aff_fname" type="text" class="form-control" name="aff_fname" value="{{ old('aff_fname') }}" required>

                                    @if ($errors->has('aff_fname'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('aff_fname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('aff_lname') ? ' has-error' : '' }}">
                                <label for="aff_lname" class="col-md-4 control-label">Nom</label>

                                <div class="col-md-6">
                                    <input id="aff_lname" type="text" class="form-control" name="aff_lname" value="{{ old('aff_lname') }}" required>

                                    @if ($errors->has('aff_lname'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('aff_lname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('aff_company') ? ' has-error' : '' }}">
                                <label for="aff_company" class="col-md-4 control-label">Société</label>

                                <div class="col-md-6">
                                    <input id="aff_company" type="text" class="form-control" name="aff_company" value="{{ old('aff_company') }}" required>

                                    @if ($errors->has('aff_company'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('aff_company') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('aff_adresse') ? ' has-error' : '' }}">
                                <label for="aff_adresse" class="col-md-4 control-label">Adresse</label>

                                <div class="col-md-6">
                                    <input id="aff_adresse" type="text" class="form-control" name="aff_adresse" value="{{ old('aff_adresse') }}" required>

                                    @if ($errors->has('aff_adresse'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('aff_adresse') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('aff_city') ? ' has-error' : '' }}">
                                <label for="aff_city" class="col-md-4 control-label">Ville</label>

                                <div class="col-md-6">
                                    <input id="aff_city" type="text" class="form-control" name="aff_city" value="{{ old('aff_city') }}" required>

                                    @if ($errors->has('aff_city'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('aff_city') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('aff_zip') ? ' has-error' : '' }}">
                                <label for="aff_zip" class="col-md-4 control-label">Code Postale :</label>

                                <div class="col-md-6">
                                    <input id="aff_zip" type="text" class="form-control" name="aff_zip" value="{{ old('aff_zip') }}" required>

                                    @if ($errors->has('aff_zip'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('aff_zip') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('aff_tel') ? ' has-error' : '' }}">
                                <label for="aff_tel" class="col-md-4 control-label">Téléphone</label>

                                <div class="col-md-6">
                                    <input id="aff_tel" type="text" class="form-control" name="aff_tel" value="{{ old('aff_tel') }}" required>

                                    @if ($errors->has('aff_tel'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('aff_tel') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('aff_orias') ? ' has-error' : '' }}">
                                <label for="aff_orias" class="col-md-4 control-label">N° ORIAS</label>

                                <div class="col-md-6">
                                    <input id="aff_orias" type="text" class="form-control" name="aff_orias" value="{{ old('aff_orias') }}" required>

                                    @if ($errors->has('aff_orias'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('aff_orias') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('aff_message') ? ' has-error' : '' }}">
                                <label for="aff_message" class="col-md-4 control-label">Message</label>

                                <div class="col-md-6">
                                    <input id="aff_message" type="text" class="form-control" name="aff_message" value="{{ old('aff_message') }}" required>

                                    @if ($errors->has('aff_message'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('aff_message') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <input id="aff_link" type="hidden" class="form-control" name="aff_link" value="{{'-1'}}">
                            <input id="aff_status_approved" type="hidden" class="form-control" name="aff_status_approved" value="{{"0"}}">
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" style="background-color: #d08639!important; border-color:#d08639!important;" class="btn btn-primary">Inscription</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
