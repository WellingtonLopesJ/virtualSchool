@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <div class="container">
        @include('layouts.showResponse')

        <h1 class="title">
            Usuário
        </h1>


        <table class="table table-hover">

            <tr>
                <th>Nome</th>
                <th>Tenant</th>
                <th width="150px">Ações</th>
            </tr>

            @if( $user )
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$tenant->name}}</td>
                    <td>
                        <form action="{{route('users.destroy', $user->name)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endif
        </table>

        <hr>

        <table class="table table-hover">
           <head><h3>Roles</h3></head>


            <form action="{{route('users.give_role')}}" method="POST">
                <input type="hidden" name="user_name" value="{{$user->name}}">
                @csrf
                <button type="submit" class="btn btn-primary">Atribuir role</button>
            </form>
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
                        <a href="{{route('role.detail', $role->id)}}" class="permission btn btn-primary">
                            <i class="fa fa-lock"></i>
                        </a>

                        <form action="{{route('users.remove_role')}}" method="POST">
                            @csrf
                            <input type="hidden" name="role_id" value="{{$role->id}}">
                            <input type="hidden" name="user_name" value="{{$user->name}}">
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
