@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Modificando el Campo</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
    {!! Form::Model($field,['route'=>['admin.fields.update',$field],'method'=>'put']) !!}
    <!--tipo del campo-->
    {!! Form::hidden('dataype', $tcampo) !!}
    {!! Form::hidden('descriptionformat', '1') !!}
    {!! Form::hidden('defaultdataformat', '0') !!}
    <!--nombre corto del curso-->
    <div class="form-group">
        {!! Form::label('shortname', 'Nombre Corto') !!}
        {!! Form::text('shortname', null, ['class' =>'form-control', 'placeholder' => "Nombre corto (debe ser unico)"]) !!}
        @error('shortname')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <!--nombre del campo-->
    <div class="form-group">
        {!! Form::label('name', 'Nombre') !!}
        {!! Form::text('name', null, ['class' =>'form-control', 'placeholder' => "Ingresa el nombre del campo"]) !!}
        @error('name')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <!--descripción del campo-->
    <div class="form-group">
        {!! Form::label('description', 'Descripcion del Campo') !!}
        {!! Form::textarea('description', null, ['class' =>'form-control']) !!}
        @error('name')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
     <!--es este campo necesario-->
     <div class="form-group">
        {!! Form::label('require', 'Es este Campo Necesario') !!}
        {!!Form::select('require', ['1' => 'si', '0' => 'no'],'0',['class' =>'form-control']);!!}
        @error('require')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <!--es este campo bloqueado-->
    <div class="form-group">
        {!! Form::label('locked', 'Esta este campo bloqueado') !!}
        {!!Form::select('locked', ['1' => 'si', '0' => 'no'],'0',['class' =>'form-control']);!!}
        @error('locked')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
      <!--debe ser unico los datos-->
    <div class="form-group">
        {!! Form::label('forceunique', 'Deberia ser unico los datos') !!}
        {!!Form::select('forceunique', ['1' => 'si', '0' => 'no'],'0',['class' =>'form-control']);!!}
        @error('forceunique')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
     <!--¿Mostrar en la Pagina para inscribirse?-->
     <div class="form-group">
        {!! Form::label('signup', '¿Mostrar en la Pagina para inscribirse?') !!}
        {!!Form::select('signup', ['1' => 'si', '0' => 'no'],'0',['class' =>'form-control']);!!}
        @error('signup')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
     <!--¿Quién puede ver este Campo?-->
     <div class="form-group">
        {!! Form::label('visible', '¿Quién puede ver este Campo?') !!}
        {!!Form::select('visible', ['1' => 'Visible por el usuario', '0' => 'No visible', '3' => 'Visible para los usuarios, profesores y administradores', '2' => 'Todos pueden verlo'],'2',['class' =>'form-control']);!!}
        @error('visible')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <!--Categoria-->
    <div class="form-group">
        {!! Form::label('category_id', 'Categoria') !!}
        {!!Form::select('category_id', $categories,$field->categoriab,['class' =>'form-control']);!!}
        @error('category_id')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <hr>
    <h4>Ajustes Específicos</h4>
    @if ($tcampo == 'checkbox')
        <!--valor por defecto-->
        <div class="form-group">
            {!! Form::label('defaultdata', 'Marcado por defecto') !!}
            {!!Form::select('defaultdata', ['1' => 'si', '0' => 'no'],'0',['class' =>'form-control']);!!}
            @error('defaultdata')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
    @elseif($tcampo == 'datetime')
    @elseif($tcampo == 'social')
    @else
            <!--valor por defecto-->
        <div class="form-group">
        {!! Form::label('defaultdata', 'Valor por defecto') !!}
        {!! Form::text('defaultdata', null, ['class' =>'form-control', 'placeholder' => "Valor por Defecto"]) !!}
        @error('defaultdata')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
    @endif 
    
    @if ($tcampo == 'texto')
        <!--Mostrar Tamaño-->
        <div class="form-group">
        {!! Form::label('param1', 'Mostrar Tamaño') !!}
        {!! Form::text('param1', 30, ['class' =>'form-control']) !!}
        @error('param1')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <!--Longitud Maximo-->
        <div class="form-group">
        {!! Form::label('param2', 'Longitud Maximo') !!}
        {!! Form::text('param2', 2048, ['class' =>'form-control']) !!}
        @error('param2')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <!--¿Es este un campo de Contraseña?-->
        <div class="form-group">
        {!! Form::label('param3', '¿Es este un campo de Contraseña?') !!}
        {!!Form::select('param3', ['1' => 'Si', '0' => 'No'],'0',['class' =>'form-control']);!!}
        @error('param3')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <!--Enlace-->
        <div class="form-group">
        {!! Form::label('param4', 'Enlace') !!}
        {!! Form::text('param4', null, ['class' =>'form-control']) !!}
        @error('param4')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <!--Enlazar Objetivo-->
        <div class="form-group">
        {!! Form::label('param5', 'Enlazar Objetivo') !!}
        {!!Form::select('param5', ['' => 'Ninguno', '_blank' => 'Nueva ventana', '_self' => 'El mismo marco', '_top' => 'La misma ventana'],'0',['class' =>'form-control']);!!}
        @error('param5')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
    @elseif($tcampo == 'menu')
        <!--Mostrar Tamaño-->
        <div class="form-group">
        {!! Form::label('param1', 'Opciones del Menu') !!}
        {!! Form::textarea('param1', null, ['class' =>'form-control','rows' =>'6','cols' =>'40']) !!}
        @error('param1')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>    
    @elseif($tcampo == 'datetime')
        <!--Alo de Inicio-->
            <div class="form-group">
            {!! Form::label('param1', 'Año de Inicio') !!}
            {!! Form::selectRange('param1', 1900, 2050,2021,['class' =>'form-control']); !!}
           @error('param1')
               <span class="text-danger">{{$message}}</span>
           @enderror
           </div>
        <!--Año de Finalización-->
            <div class="form-group">
            {!! Form::label('param2', 'Año de Finalización') !!}
            {!! Form::selectRange('param2', 1990, 2050,2021 ,['class' =>'form-control']);!!}
            @error('param2')
                <span class="text-danger">{{$message}}</span>
            @enderror
            </div> 
        <!--incluir tiempo-->
        <div class="form-group">
            {!! Form::label('param3', '¿Incluir Tiempo?') !!}
            {!!Form::checkbox('param3', '1');!!}
            @error('param3')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>  
    @elseif($tcampo == 'social')
        <!--¿Es este un campo de Contraseña?-->
        <div class="form-group">
        {!! Form::label('param1', 'Tipo de Red') !!}
        {!!Form::select('param1', [
            '0' => 'Seleccionar',
            'icq' => 'Numero de ICQ',
            'msm' => 'ID MSM',
            'aim' => 'ID AIM',
            'yahoo' => 'ID Yahoo',
            'skype' => 'ID Skype',
            'url' => 'Pagina Web',
            ],'0',['class' =>'form-control']);!!}
        @error('param1')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
    
    @elseif($tcampo == 'textarea')
    @else
    @endif

    <!--boton guardar-->
    {!! Form::submit('Modificar Campo', ['class' => 'btn btn-primary']) !!}
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