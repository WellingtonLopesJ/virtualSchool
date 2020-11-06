@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <script src="{{ asset('js/app.js') }}" defer></script>

    <div class="container" id="app">

        @include('layouts.showResponse')


        <header>
            <h3>Editar todas as ocorrências desta aula</h3>
        </header>

        <form action="{{route('fixedLessons.update', $fixed_lesson->slug)}}" method="POST">

            @if($fixed_lesson->canceled == true)<fieldset disabled="disabled">@endif

            @method('PUT')
            @csrf


            <div class="form-group">
                <label for="name">Local:</label>
                <location-search-bar></location-search-bar>
            </div>

            <div class="form-group">
                <label for="date">Data da próxima aula:</label>
                <input type="datetime-local" class="form-control" id="date" name="date" value="{{$nextLessonDate}}">
            </div>

            <div class="form-group">
                <label for="students">Alunos:</label>
                <student-search-bar></student-search-bar>
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
