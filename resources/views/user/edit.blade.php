@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Edition d'un affilié</h3></div>
                    <div class="panel-body">

                        {!! Form::model(
                          $user,
                          array(
                        'route' => array('user.update', $user->id),
                        'method' => 'PUT'))
                          !!}

                        {!! Form::label('email', 'Adresse email') !!}
                        {!! Form::text('email', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Adresse email']) !!}

                        {!! Form::label('aff_civility', 'Civilité') !!}
                        {!!  Form::select('aff_civility', ['0' => 'Monsieur', '1' => 'Madame ou Mademoiselle'],Null, ['class' => 'form-control' ],['placeholder' => 'Civilité']) !!}

                        {!! Form::label('aff_fname', 'Prénom') !!}
                        {!! Form::text('aff_fname', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Prénom']) !!}

                        {!! Form::label('aff_lname', 'Nom') !!}
                        {!! Form::text('aff_lname', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Nom']) !!}

                        {!! Form::label('aff_company', 'Société') !!}
                        {!! Form::text('aff_company', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Société']) !!}

                        {!! Form::label('aff_adresse', 'Adresse') !!}
                        {!! Form::text('aff_adresse', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Adresse']) !!}

                        {!! Form::label('aff_city', 'Ville') !!}
                        {!! Form::text('aff_city', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Ville']) !!}

                        {!! Form::label('aff_zip', 'Code postale') !!}
                        {!! Form::text('aff_zip', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Code postale']) !!}

                        {!! Form::label('aff_tel', 'Téléphone') !!}
                        {!! Form::text('aff_tel', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Téléphone']) !!}

                        {!! Form::label('aff_orias', 'N°Orias') !!}
                        {!! Form::text('aff_orias', null,
                        ['class' => 'form-control',
                        'placeholder' => 'N°Orias']) !!}

                        {!! Form::label('aff_ref', 'Référence affilié') !!}
                        {!! Form::text('aff_ref', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Référence affilié']) !!}

                        {!! Form::label('aff_message', 'Message') !!}
                        {!! Form::textarea('aff_message', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Message']) !!}

                        {!! Form::label('aff_status_approved', 'Status') !!}
                        {!!  Form::select('aff_status_approved', ['0' => 'Inactif', '1' => 'Actif'],Null, ['class' => 'form-control' ],['placeholder' => 'Status']) !!}
                        <br>
                        <p>Test courtier {{$user->aff_link}}</p>
                        <div>
                            <a href="{{ url('/user') }}">Retour</a> -
                            @if($user->aff_link == -1)
                            <a href="{{ route('convert_aff', $user->id) }}">Convertir en courtier</a>
                                @else
                                <a href="{{ route('convert_courtier', $user->id) }}">Convertir en affilié</a>
                            @endif
                        </div>
                        {!! Form::submit('Modifier l\'affilié',
                        ['class' => 'btn btn-group-justified',
                        'style' => 'background-color: #d08639!important; border-color:#d08639!important;color:white;']) !!}

                        <style>.btn-group-justified{background-color: lightsteelblue}</style>


                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection