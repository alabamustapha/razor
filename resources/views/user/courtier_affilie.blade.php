@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><center><h5>Les courtiers de {{$user->aff_fname}}, {{$user->aff_lname}} </h5></center></div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Ville</th>
                                    <th>Date d'inscription</th>
                                    <th>Dernière connexion</th>
                                    <th>Réf affilié</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($affilie as $user_affil)
                                    <tr>


                                        <td>@if($user_affil->aff_status_approved == 1)
                                                Actif

                                            @else
                                                Inactif

                                            @endif</td>

                                        <td>
                                            @if($user_affil->aff_civility == 0)
                                                M.
                                            @else
                                                Mme.
                                            @endif
                                            {{ $user_affil->aff_lname }}</td>
                                        <td>{{$user_affil->aff_fname }}</td>
                                        <td>{{ $user_affil->aff_city }}</td>
                                        <td>{{ $user_affil->created_at }}</td>
                                        <td>{{ $user_affil->updated_at }}</td>
                                        <td>{{ $user_affil->aff_ref }}</td>
                                        <td><a href="{{ route('user.edit', $user_affil->id)}}"><i class="fa fa-pencil-square-o"></i></a>
                                            <a href=""><i style="color: red;" class="fa fa-times" aria-hidden="true"></i></a><br>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection