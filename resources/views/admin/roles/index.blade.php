@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <div class="container" >
        <h1 class="title">
            Roles list
        </h1>


        <table class="table table-hover">
            @include('layouts.showResponse')
            <a href="{{route('roles.create')}}" class="btn btn-primary">Criar Role</a>
            <tr>
                <th>Name</th>
                <th>Label</th>
                <th width="150px">Permissões</th>
                <th width="150px">Excluir</th>
            </tr>

            @forelse( $roles as $role )
                <tr>
                    <td>{{$role->name}}</td>
                    <td>{{$role->label}}</td>
                    <td>
                        <a href="{{route('roles.permissions', $role->id)}}" class="permission btn btn-primary">
                            <i class="fa fa-lock"></i>
                        </a>
                    </td>
                    <td>
                        <form action="{{route('roles.destroy', $role->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="90">
                        <p>Nenhum Resultado!</p>
                    </td>
                </tr>
            @endforelse
        </table>

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
