@extends('adminlte::page')

@section('title', 'Recarga')

@section('content_header')
    <h1>Adicionar saldo</h1>
@stop

@section('content')

    @include('layouts.showResponse')

    <div>
        <p>Saldo atual: {{$student->credits}}</p>
    </div>

    <form method="POST" action="{{route('balance.deposit.store')}}">
        @csrf

        <input type="hidden" name="student_slug" value="{{$student->slug}}">

        <div class="form-group">
            <input type="number" placeholder="Valor Recarga" name="value" autocomplete="off">
        </div>

        <div class="form-group"><input type="submit" name=""></div>

    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
