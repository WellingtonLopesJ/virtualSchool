@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <script src="{{ asset('js/app.js') }}" defer></script>

    <div class="container" id="app">

        @include('layouts.showResponse')


        <header><h3>Editar aula |
                @if($lesson->canceled == false)
                    <a href="{{route('aulas.cancel', $lesson->slug)}}" class="btn btn-danger text-white">Cancelar aula</a>
                @else
                    <a href="{{route('aulas.uncancel', $lesson->slug)}}" class="btn btn-success text-white">Reestabelecer aula</a>
                @endif
            </h3>
        </header>

        <form action="{{route('aulas.update', $lesson->slug)}}" method="POST">

            @if($lesson->canceled == true)<fieldset disabled="disabled">@endif

            @method('PUT')
            @csrf


            <div class="form-group">
                <label for="name">Local:</label>
                <location-search-bar></location-search-bar>
            </div>

            <div class="form-group">
                <label for="date">Data:</label>
                <input type="datetime-local" class="form-control" id="date" name="date" value="{{$lesson->start}}">
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
