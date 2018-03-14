@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3><center>Les clauses</center></h3></div>
                    <div class="panel-body">
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <a href="{{ url('/indicedebase') }}" class="btn btn-default">Acceuil</a>
                            </div>
                            <div class="btn-group" role="group">
                                <a href="{{ url('/user') }}" class="btn btn-default">Gérer affiliés</a>
                            </div>
                            <div class="btn-group" role="group">
                                <a href="#" class="btn btn-default">Gèrer devis et contrats</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <a href="{{ route('clauses.create')}}">Crée un indice</a>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Indice</th>
                                <th>Valeur</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>


                                <tr>
                                    <td><p></p></td>
                                    <td></td>
                                    <td id="flex">
                                        <a href=""><i class="fa fa-pencil-square-o"></i></a>

                                    </td>
                                </tr>





                            </tbody>
                        </table>

                        {{--  {!! Form::model($indice, array('route' => ['indicedebase.destroy', $indice->id], 'method' => 'DELETE')) !!}
                                       {{ Form::button('<i class="fa fa-trash-o"></i>', array('class'=>'btn btn-danger btn-xs', 'type'=>'submit')) }}
                                       {!! Form::close() !!} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection