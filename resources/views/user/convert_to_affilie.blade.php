@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="text-center"><h5>Etês-vous sûr de vouloir convertir le courtier {{$user->aff_lname}}, {{$user->aff_fname}} en affilié et les données liées ?</h5></div></div>
                    <div class="panel-body">
                        <center><form class="form-horizontal" method="post" action="{{ route('update_afflink_post2', $user->id) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="convert_courtier_to_affilie" value="-1">
                                <center><a href="{{ route('user.edit', $user->id)}}">Non, retour</a> - <button style="color: red; background-color: transparent; border: none;"  type="submit">Convertir</button></center>
                            </form></center>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection