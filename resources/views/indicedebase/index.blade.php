@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Mes indices de base</h3></div>
                    <div class="panel-body">
                        <p>Le montant doit être spécifié avec un point et non une virgule.</p>
                        {{--<a href="{{ route('indicedebase.create')}}">Crée un indice</a>--}}
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Indice</th>
                                <th>Valeur</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($indice_de_base as $indice)


                                <tr>
                                    <td><p>{{ $indice->indice }}</p></td>
                                    <td>{{ $indice->valeur }}</td>
                                    <td id="flex">
                                        <a href="{{ route('indicedebase.edit', $indice->id)}}"><i class="fa fa-pencil-square-o"></i></a>

                                    </td>
                                </tr>




                            @endforeach
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