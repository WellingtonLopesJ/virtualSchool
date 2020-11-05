@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <div class="container">
        <h1 class="title">
            Aula - {{$lesson->FormatedDate}}
        </h1>

        <table class="table table-hover">
            <thead><h3>Alunos:</h3></thead>
            @include('layouts.showResponse')

            <tr>
                <th>Name</th>
                <th>Data de nascimento</th>
                <th width="150px">Aulas</th>
            </tr>

            @forelse( $students as $student )
                <tr>
                    <td>{{$student->name}}</td>
                    <td>{{$student->formatedBirthday}}</td>
                    <td><i class="fa fa-lock"></i></td>
                </tr>
            @empty
                <tr>
                    <td colspan="90">
                        <p>Nenhum Resultado!</p>
                    </td>
                </tr>
            @endforelse
        </table>

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
