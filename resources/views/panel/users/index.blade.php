@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')


    <div class="container" >
        <h1 class="title">
            Users list
        </h1>


        <table class="table table-hover">
            @include('layouts.showResponse')
            <a href="{{route('users.create')}}" class="btn btn-primary">Criar user</a>
            <tr>
                <th>Name</th>
                <th>Tenant</th>
                <th>Email</th>
                <th>Ver</th>
                <th>excluir</th>
            </tr>

            @forelse( $users as $user )
                <tr>

                    <td>{{$user->name}}</td>
                    <td>{{$user->tenant()->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <a href="{{route('users.show',$user->name)}}" class="permission btn btn-primary">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </td>
                    <td>
                        <form action="{{route('users.destroy', $user->name)}}" method="POST">
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
