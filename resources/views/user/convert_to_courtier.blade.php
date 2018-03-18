@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="text-center">
                            <h5>Sélectionner l'affilié auquel rattaché le courtier {{$user->aff_lname}}, {{$user->aff_fname}} et les données liées :</h5>
                        </div>
                    </div>
                    <div class="panel-body">
                        <center><form class="form-horizontal" method="post" action="{{ route('update_afflink_post', $user->id) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <select name="convert_affilie_to_courtier">
                            @foreach($affilie as $aff)
                                    <option value="{{$aff->id}}">{{$aff->aff_fname}}, {{$aff->aff_lname}}</option>
                                @endforeach
                            </select>
                                <center><a href="{{ route('user.edit', $user->id)}}">Annuler</a> - <button style="color: red; background-color: transparent; border: none;"  type="submit">Convertir</button></center>
                        </form></center>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection