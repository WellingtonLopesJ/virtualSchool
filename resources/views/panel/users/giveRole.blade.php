@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <div class="container">

        @include('layouts.showResponse')

        <form action="{{route('users.store_role')}}" method="POST">

            @csrf

            <header><h3>Adicionar role para {{$user->name}}</h3></header>

            <div class="form-group">
                <label for="">Roles</label>

                <input type="hidden" name="user_name" value="{{$user->name}}">

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
