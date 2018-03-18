@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Les affiliés</h3></div>
                    <div class="panel-body">
                        <h4>Gestion des affilié et des courtiers</h4>
                        <a href="{{ route('user.create')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i>Ajouter un affilié</a>
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
                                    <th>Nombre de courtier</th>
                                    <th>Réf affilié</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user as $user_affil)
                                    <tr>


                                        <td>@if($user_affil->aff_status_approved == 1)
                                                <p style="color: green">Actif</p>

                                            @else
                                                <p style="color: red">Inactif</p>

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
                                        <td><?php foreach($user_aff as $user_count){
                                              echo  count($user_count->aff_link == $user_affil->id);
                                            }?>

                                        </td>
                                        <td>{{ $user_affil->aff_ref }}</td>
                                        <td><a href="{{ route('user.edit', $user_affil->id)}}"><i class="fa fa-pencil-square-o"></i></a>
                                            <a href=""><i style="color: red;" class="fa fa-times" aria-hidden="true"></i></a><br>
                                            <a href="{{route('courtier_affilie', $user_affil->id)}}">Gérer les courtiers</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{--  {!! Form::model($indice, array('route' => ['indicedebase.destroy', $indice->id], 'method' => 'DELETE')) !!}
                                       {{ Form::button('<i class="fa fa-trash-o"></i>', array('class'=>'btn btn-danger btn-xs', 'type'=>'submit')) }}
                                       {!! Form::close() !!} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection