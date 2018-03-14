@extends('layouts.php')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Admin indice</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ url('/register') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group{{ $errors->has('indice') ? ' has-error' : '' }}">
                                <label for="indice" class="col-md-4 control-label">Nom de l'indice :</label>

                                <div class="col-md-6">
                                    <input id="indice" type="text" class="form-control" name="indice" value="{{ old('indice') }}" required autofocus>

                                    @if ($errors->has('indice'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('indice') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('valeur') ? ' has-error' : '' }}">
                                <label for="valeur" class="col-md-4 control-label">Valeur</label>

                                <div class="col-md-6">
                                    <input id="valeur" type="text" class="form-control" name="valeur" required>

                                    @if ($errors->has('valeur'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('valeur') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">Modifié l'indice de base</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection