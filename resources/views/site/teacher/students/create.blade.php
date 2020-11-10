@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <script src="{{ asset('js/app.js') }}" defer></script>

    <div class="container" id="app">

        @include('layouts.showResponse')

        <form action="{{route('alunos.store')}}" method="POST">

            @csrf
            <header><h3>Cadastrar aluno</h3></header>

            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>

            <div class="form-group">
                <label for="birthday">Data de nascimento:</label>
                <input type="date" class="form-control" id="birthday" name="birthday">
            </div>

            <div class="form-group">
                <label for="name">Local:</label>
                <location-search-bar></location-search-bar>
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
