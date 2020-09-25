@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <div class="container">

        @include('layouts.showResponse')

        <form action="{{route('users.store')}}" method="POST">

            @csrf
            <header><h3>Criar novo user</h3></header>
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nome">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>

            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nome">
            </div>

            <div class="form-group">
                <label for="permissions">Roles</label>


                @forelse($roles as $role)

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="{{$role->id}}" value="{{$role->id}}" name="roles[]">
                        <label class="form-check-label" for="{{$role->id}}">{{$role->name}}</label>
                    </div>

                @empty

                @endforelse

            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
