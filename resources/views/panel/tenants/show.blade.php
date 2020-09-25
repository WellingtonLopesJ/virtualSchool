@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <div class="container">
        <h1 class="title">
            Usuários de {{$tenant->name}}
        </h1>

        <table class="table table-hover">
            @include('layouts.showResponse')

            <form action="{{route('users.create')}}" metohd="POST">
                @csrf
                <input type="hidden" name="tenant_id" value="{{$tenant->id}}">
                <button type="submit" class="btn btn-primary">Criar user neste tenant</button>
            </form>
            <tr>
                <th>Name</th>
                <th>Roles</th>
                <th width="150px">Ações</th>
            </tr>

            @forelse( $users as $user )
                <tr>
                    <td>{{$user->name}}</td>
                    <td><a href="{{route('users.show', $user->id)}}">{{$user->roles->first()->name}}</a></td>
                    <td>
                        <form action="{{--{{route('tenants.remove_user')}}--}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="tenantId" value="{{$tenant->id}}">
                            <input type="hidden" name="userId" value="{{$user->id}}">
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
