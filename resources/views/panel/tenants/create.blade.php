@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <div class="container">

        @include('layouts.showResponse')

        <form action="{{route('tenants.store')}}" method="POST">

            @csrf
            <header><h3>Criar novo tenant</h3></header>
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nome do tenant" required>
            </div>

            <div class="form-group">
                <label for="subdomain">Subdomain:</label>
                <input type="text" class="form-control" id="subdomain" name="subdomain" placeholder="subdomain do tenant" required>
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
