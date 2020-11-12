@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <script src="{{ asset('js/app.js') }}" defer></script>

    <div class="container" id="app">

        @include('layouts.showResponse')

        <form action="{{route('aulas.store')}}" method="POST">

            @csrf
            <header><h3>Criar nova aula</h3></header>

            <div class="form-group">
                <label for="name">Local:</label>
                <location-search-bar></location-search-bar>
            </div>

            <div class="form-group">
                <label for="date">Data:</label>
                <input type="datetime-local" class="form-control" id="date" name="date">
            </div>

            <div class="form-group">
                <label for="students">Alunos:</label>
                <student-search-bar></student-search-bar>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Repetir</label>
                </div>
                <select class="custom-select" id="inputGroupSelect01" name="repeat">
                    <option selected value="single">Aula única</option>
                    <option value="weekly">Semanalmente</option>
                </select>

            </div>


                <div id="has_endGroup" hidden="hidden" class="form-check">
                    <input type="checkbox" name="has_end" id="has_end" class="form-check-input">
                    <label for="has_end" class="form-check-label">Definir data final</label>
                </div>

                <div class="form-group" id="end_dateGroup" hidden="hidden">
                    <label for="end_date">Parar de agendar em:</label>
                    <input name="end_date" id="end_date" type="date" class="form-control"/>
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
        $(document).ready(function(){

            $("#has_end").change(function () {
                var selected_option = $('#has_end').val();
                if (selected_option === "on") {
                    $("#end_dateGroup").removeAttr('hidden').show();
                    $('#has_end').val("off");
                }
                if (selected_option === "off") {
                    $('#end_dateGroup').attr('hidden','hidden').show();
                    $('#has_end').val("on");
                }
            })

            $("#inputGroupSelect01").change(function () {
                var selected_option = $('#inputGroupSelect01').val();

                if (selected_option !== 'weekly') {
                    $('#has_endGroup').attr('hidden','hidden').show();
                }
                if (selected_option === 'weekly') {
                    $("#has_endGroup").removeAttr('hidden').show();
                }
            })

        })
    </script>
@stop
