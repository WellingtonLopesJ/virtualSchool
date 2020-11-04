@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <div class="container">

        @include('layouts.showResponse')

        <form action="{{route('roles.store')}}" method="POST">

            @csrf
            <header><h3>Criar novo role</h3></header>
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nome do role">
            </div>

            <div class="form-group">
                <label for="label">Label</label>
                <input type="text" class="form-control" id="label" name="label" placeholder="Descrição do role">
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
