@extends('layouts.admin')
    @section('content')
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Recherche</div>
                        <div class="panel-body">

                        {!! Form::open(array(
                        'url' => 'tarificateurbatiment/result_search',
                         'method' => 'PUT', 'class' => 'form-horizontal')) !!}

                        {!! Form::select('type_product', array('0' => 'Nouveau Devis', '1' => 'Ancien Devis'),null, ['class' => 'form-control']) !!}

                        {!! Form::select('product_choice', array('0' => 'N° Devis', '1' => 'Par courtier'), null, ['class' => 'form-control'] ) !!}
                        
                        {!! Form::text('search', null,
                        ['class' => 'form-control',
                        'placeholder' => 'N°Devis, Courtier']) !!}

                        
                        <br>
                        {!! Form::submit('Rechercher',
                        ['class' => 'btn btn-group-justified btn-orange']) !!}

                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection