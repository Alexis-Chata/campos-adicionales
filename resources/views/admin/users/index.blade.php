@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de Usuarios</h1><hr>
    <div class="card-header">
        <a class="btn btn-secondary" href="{{route('admin.users.create')}}">Agregar Usuarios</a>
    </div>
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td width='10px'><a href="{{route('admin.users.edit',$user)}}" class="btn btn-primary btn-sm">Editar</a></td>
                            <td width='10px'>
                                <form action="{{route('admin.users.destroy',$user)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@stop

@section('content')
@stop
