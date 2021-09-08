@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Categorias</h1>
@stop

@section('content')
@if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
<div class="row profileeditor">
    <div class="col align-self-end">
        <a href="{{route('admin.categories.create')}}" tabindex="0" role="button" class="btn btn-secondary float-right" data-action="editcategory">Crear una nueva categoría de perfiles</a>
    </div>
</div>
<!--Categorias-->
<div class="categorieslist">
    <!--Lista de categorias-->
    @foreach ($categories as $category)
    <div class="row justify-content-between align-items-end">
        <div class="col-6 categoryinstance">
            <!--titulo-->
            <h5>{{$category->name}}
            <!--editar-->
            <a href="{{route('admin.categories.edit',$category)}}" data-action="editcategory" data-id="1" data-name="Otros campos">
            <i class="icon fa fa-cog fa-fw " title="Editar" aria-label="Editar"></i></a>
            <!--eliminar-->
            @if (count($categories) > 1)
            <a href="#" onclick="document.getElementById('formulario-{{$category->id}}').submit();">
            <i class="icon fa fa-trash fa-fw " title="Borrar" aria-label="Borrar"></i>
            </a>
            @else
            @endif
            <!--mover hacia abajo-->
            @if ($loop->last)
            @else
            <a href="{{route('admin.categories.mover',[$category,'+'])}}">
            <i class="icon fa fa-arrow-down fa-fw " title="Mover hacia abajo" aria-label="Mover hacia abajo"></i>
            </a>     
            @endif
            <!--mover hacia Arriba-->
            @if ($category->sortorder != '1' )
            <a href="{{route('admin.categories.mover',[$category,'-'])}}">
            <i class="icon fa fa-arrow-up fa-fw " title="Mover hacia arriba" aria-label="Mover hacia arriba"></i>
            </a>
            @endif
            <form action="{{route('admin.categories.destroy',$category)}}" method="POST" name="formulario-{{$category->id}}" id="formulario-{{$category->id}}">
            @csrf
            @method('DELETE') 
            </form>
            </h5>
        </div>
        <div class="col-auto text-right">
            <div class="action-menu moodle-actionmenu float-left mr-1 d-inline" id="action-menu-3" data-enhance="moodle-core-actionmenu">

                <div class="menubar d-flex " id="action-menu-3-menubar" role="menubar">
    
                    <div class="action-menu-trigger">
                        <div class="dropdown">
                            <a href="#" tabindex="0" class="d-inline-block  dropdown-toggle icon-no-margin" id="action-menu-toggle-3" aria-label="Crear un nuevo campo de perfil:" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" aria-controls="action-menu-3-menu">
                                
                                Crear un nuevo campo de perfil:
                                    
                                <b class="caret"></b>
                            </a>
                                <div class="dropdown-menu dropdown-menu-right menu  align-bl-bl" id="action-menu-3-menu" data-rel="menu-content" aria-labelledby="action-menu-toggle-3" role="menu" data-align="bl-bl">
                                                                    <a href="{{route('admin.fields.create2',['checkbox',$category->id])}}" class="dropdown-item menu-action" data-action="createfield" data-categoryid="1" data-datatype="checkbox" data-datatypename="Casilla de verificación" role="menuitem" aria-labelledby="actionmenuaction-8">
                                    <span class="menu-action-text" id="actionmenuaction-8">Casilla de verificación</span>
                            </a>
                                                                    <a href="{{route('admin.fields.create2',['texto',$category->id])}}" class="dropdown-item menu-action" data-action="createfield" data-categoryid="1" data-datatype="text" data-datatypename="Entrada de texto" role="menuitem" aria-labelledby="actionmenuaction-9">
                                    <span class="menu-action-text" id="actionmenuaction-9">Entrada de texto</span>
                            </a>
                                                                    <a href="{{route('admin.fields.create2',['datetime',$category->id])}}" class="dropdown-item menu-action" data-action="createfield" data-categoryid="1" data-datatype="datetime" data-datatypename="Fecha / Hora" role="menuitem" aria-labelledby="actionmenuaction-10">
                                    <span class="menu-action-text" id="actionmenuaction-10">Fecha / Hora</span>
                            </a>
                                                                    <a href="{{route('admin.fields.create2',['menu',$category->id])}}" class="dropdown-item menu-action" data-action="createfield" data-categoryid="1" data-datatype="menu" data-datatypename="Menú desplegable" role="menuitem" aria-labelledby="actionmenuaction-11">
                                    <span class="menu-action-text" id="actionmenuaction-11">Menú desplegable</span>
                            </a>
                                                                    <a href="{{route('admin.fields.create2',['social',$category->id])}}" class="dropdown-item menu-action" data-action="createfield" data-categoryid="1" data-datatype="social" data-datatypename="Social" role="menuitem" aria-labelledby="actionmenuaction-12">
                                    <span class="menu-action-text" id="actionmenuaction-12">Social</span>
                            </a>
                                                                    <a href="{{route('admin.fields.create2',['textarea',$category->id])}}" class="dropdown-item menu-action" data-action="createfield" data-categoryid="1" data-datatype="textarea" data-datatypename="Área de texto" role="menuitem" aria-labelledby="actionmenuaction-13">
                                    <span class="menu-action-text" id="actionmenuaction-13">Área de texto</span>
                            </a>
                                </div>
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    </div>
    <!--aca se crea la tabla -->
    <div class="card">
        <div class="card-header">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="col-8">Campo del perfil</th>
                        <th scope="col" class="col-3 text-right">Editar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category->campos->sortBy("sortorder") as $campo)
                    <tr>
                        <td class="col-8">
                        {{$campo->name}}
                        </td>
                        <td class="col-3 text-right">
                        <a href="{{route('admin.fields.edit',$campo)}}" data-action="editfield" data-id="3" data-name="dni">
                            <i class="icon fa fa-cog fa-fw " title="Editar" aria-label="Editar"></i></a>
                        <a href="#" onclick="document.getElementById('formulario2-{{$campo->id}}').submit();">
                            <i class="icon fa fa-trash fa-fw " title="Borrar" aria-label="Borrar"></i></a>
                            @if ($loop->last)
                            @else
                            <a href="{{route('admin.fields.mover',[$campo,'+'])}}">
                            <i class="icon fa fa-arrow-down fa-fw " title="Mover hacia abajo" aria-label="Mover hacia abajo"></i></a>
                            @endif
                            @if ($loop->first)
                            @else 
                            <a href="{{route('admin.fields.mover',[$campo,'-'])}}">
                            <i class="icon fa fa-arrow-up fa-fw " title="Mover hacia arriba" aria-label="Mover hacia arriba"></i>
                            @endif
                        </td>
                        <form action="{{route('admin.fields.destroy',$campo)}}" method="POST" name="formulario2-{{$campo->id}}" id="formulario2-{{$campo->id}}">
                            @csrf
                            @method('DELETE') 
                        </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> 
    @endforeach
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop