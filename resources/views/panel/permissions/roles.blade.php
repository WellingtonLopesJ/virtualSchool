@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <div class="container">
        <h1 class="title">
            roles de {{$permission->name}}
        </h1>

        <table class="table table-hover">
            @include('layouts.showResponse')

            <tr>
                <th>Name</th>
                <th>Label</th>
                <th width="150px">Ações</th>
            </tr>

            @forelse( $roles as $role )
                <tr>
                    <td>{{$role->name}}</td>
                    <td>{{$role->label}}</td>
                    <td>
                        <form action="{{route('roles.remove_permission')}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="roleId" value="{{$permission->id}}">
                            <input type="hidden" name="permissionId" value="{{$role->id}}">
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
