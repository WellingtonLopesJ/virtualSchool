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

            @if($fixed_lesson->canceled == true)
                <fieldset disabled="disabled"></fieldset>@endif

            @method('PUT')
            @csrf


            <div class="form-group">
                <label for="name">Local:</label>
                <location-search-bar></location-search-bar>
            </div>

            <div class="form-group">
                <label for="date">Data da próxima aula:</label>
                <small>Todas as próximas serão no mesmo dia da semana e hora</small>
                <input type="datetime-local" class="form-control" id="date" name="date" value="{{$nextLessonDate}}">
            </div>

            <div class="form-group">
                <label for="students">Alunos:</label>
                <student-search-bar></student-search-bar>
            </div>

            <div id="has_endGroup" class="form-check">
                <input type="checkbox" name="has_end" id="has_end" class="form-check-input">
                <label for="has_end" class="form-check-label">Definir data final</label>
            </div>

            <div class="form-group" id="end_dateGroup" hidden="hidden">
                <label for="end_date">Data final:</label>
                <small>Todas as ocorrências posteriores desta aula serão deletadas</small>
                <input name="end_date" id="end_date" type="date" min="{{date('Y-m-d')}}" value="{{$fixed_lesson->end_date}}" class="form-control"/>
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
    <script>
        $(document).ready(function () {

            var fixed_lesson = {!! json_encode($fixed_lesson) !!}

            //Controla a checkbox
            if (fixed_lesson.end_date) {
                $('#has_end').prop('checked', true)
                $('#has_end').val("on")
                $("#has_endGroup").removeAttr('hidden').show();
                $("#end_dateGroup").removeAttr('hidden').show();
            }else{
                $('#has_end').val("off")
            }

                //Controla o datepicker
                $("#has_end").change(function () {
                    var selected_option = $('#has_end').val();

                    if (selected_option === "off" || selected_option !== 'on') {
                        $("#end_dateGroup").removeAttr('hidden').show();
                        $('#has_end').val("on");
                    }

                    if (selected_option === "on") {
                        $('#end_dateGroup').attr('hidden', 'hidden').show();
                        $('#has_end').val("off");
                    }
                })

        })
    </script>
@stop
