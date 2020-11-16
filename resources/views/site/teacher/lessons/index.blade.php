@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')



    <div class="container" >

        <!-- basic modal -->
        <div class="modal" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Agendar aula</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Horário:</p> <p id="lessonStart"></p>
                    </div>
                    <div class="modal-footer">
                        <form action="{{route('aulas.create')}}" method="post">
                            @csrf
                            <input type="hidden" name="start" id="start">
                            <input type="hidden" name="end" id="end">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Agendar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <h1 class="title">
            Lessons list
        </h1>


        @include('layouts.showResponse')
        {{--<a href="{{route('aulas.create')}}" class="btn btn-primary">Agendar aula</a>--}}
        <button class="btn btn-primary" id="createButton">Agendar aula</button>
        <a href="{{route('alunos.create')}}" class="btn btn-primary">Cadastrar aluno</a>

        @include('layouts.calendar')

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        document.getElementById('createButton').onclick = function () {
            Swal.fire(
                'Agendar aula',
                'Selecione um horário vazio no calendário',
                'success'
            )
        };

    </script>

@stop
