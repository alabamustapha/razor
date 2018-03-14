    @extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Ajouter un affilié</div>
                    <div class="panel-body">


                        {!! Form::open(array(
                        'route' => 'user.store',
                         'method' => 'POST')) !!}

                        {!! Form::label('email', 'Adresse email') !!}
                        {!! Form::text('email', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Adresse email']) !!}

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

                        {!! Form::label('aff_message', 'Message') !!}
                        {!! Form::text('aff_message', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Message']) !!}
                        <br>
                        {!! Form::submit('Ajouter un affilié',
                        ['class' => 'btn btn-group-justified']) !!}

                        <style>.btn-group-justified{background-color: lightsteelblue}</style>


                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection