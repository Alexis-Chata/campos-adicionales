@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Crear Usuario</h1><hr>
@stop

@section('content')
@if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'admin.users.store']) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Nombre') !!}
                    {!! Form::text('name', null, ['class' =>'form-control', 'placeholder' => "Ingrese el nombre del usuario"]) !!}
                    @error('name')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::email('email', null, ['class' =>'form-control', 'placeholder' => "Ingrese el correo del usuario"]) !!}
                    @error('email')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('password', 'Contraseña',['class' => 'col-sm-2 col-form-label']) !!}
                    {!! Form::password('password', ['class' =>'form-control']) !!}
                    @error('password')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Confirmar Contraseña') !!}
                    {!! Form::password('password_confirmation', ['class' =>'form-control']) !!}
                    @error('password_confirmation')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                </div>
                <!--Categorias-->
                @foreach ($categories as $category)
                    @if ($category->campos->count()!=0)    
                    <hr>    
                    <h4>{{$category->name}}<h4>
                        @foreach ($category->campos as $campo)
                        <!--tipo del campo-->
                        {!! Form::hidden('idcampos[]', $campo->id) !!}    
                        @if ($campo->dataype == "texto")
                                <div class="form-group">
                                {!! Form::label('vcampos[]', $campo->shortname) !!}
                                @if ($campo->param3 == '1')
                                {!! Form::password('vcampos[]', ['class' =>'form-control', 'size' => $campo->param1,'maxlength' => $campo->param2]) !!}
                                @else
                                {!! Form::text('vcampos[]', $campo->defaultdata, ['class' =>'form-control', 'size' => $campo->param1,'maxlength' => $campo->param2]) !!}
                                    @endif
                                @error('vcampos[]')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                                </div>
                            @elseif ($campo->dataype == "menu")
                                <div class="form-group">
                                {!! Form::label('vcampos[]', $campo->name) !!}
                                {!!Form::select('vcampos[]', explode (' ',$campo->param1),null,['class' =>'form-control']);!!}
                                @error('vcampos[]')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                </div>
                            @elseif ($campo->dataype == "checkbox")    
                                <div class="form-group">
                                {!! Form::label('vcampos[]', $campo->name) !!}
                                {!!Form::checkbox('vcampos[]',1)!!}
                                @error('vcampos[]')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                </div>
                            @elseif ($campo->dataype == "datetime")    
                                <div class="form-group">
                                {!! Form::label('vcampos[]', $campo->name) !!}
                                @if ($campo->param3 == "1")
                                {!! Form::datetimeLocal('vcampos[]', \Carbon\Carbon::create()->format('d/m/Y H:i:s'), ['class' =>'form-control']) !!}
                                @else
                                {!!Form::date('vcampos[]', \Carbon\Carbon::create()->format('d/m/Y H:i:s'), ['class' =>'form-control'])!!}
                                @endif
                                @error('vcampos[]')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                </div>
                            @elseif ($campo->dataype == "textarea")    
                            <div class="form-group">
                                {!! Form::label('vcampos[]', $campo->name) !!}
                                {!! Form::textarea('vcampos[]',$campo->defaultdata, ['class' =>'form-control']) !!}
                                @error('vcampos[]')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                </div>
                            @elseif ($campo->dataype == "social")
                                <div class="form-group">
                                {!! Form::label('vcampos[]', $campo->name) !!}
                                {!! Form::text('vcampos[]',null, ['class' =>'form-control']) !!}
                                @error('vcampos[]')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                </div>
                            @endif
                        @endforeach
                
                    @endif
                @endforeach
                {!! Form::submit('Crear Usuario', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop