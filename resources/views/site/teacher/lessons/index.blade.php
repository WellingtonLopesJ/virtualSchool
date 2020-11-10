@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <div class="container" >
        <h1 class="title">
            Lessons list
        </h1>
        @include('layouts.showResponse')
        <a href="{{route('aulas.create')}}" class="btn btn-primary">Criar Lesson</a>
        <a href="{{route('alunos.create')}}" class="btn btn-primary">Cadastrar aluno</a>

        @include('layouts.calendar')

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
