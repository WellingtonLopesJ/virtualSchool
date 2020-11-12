@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <div class="container" >
        <h1 class="title">
            Alunos
        </h1>


        <table class="table table-hover">
            @include('layouts.showResponse')
            <a href="{{route('alunos.create')}}" class="btn btn-primary">Cadastrar aluno</a>
            <tr>
                <th>Nome</th>
                <th>Data de nascimento</th>
                <th width="150px">Ver</th>
                <th width="150px">Saldo</th>
            </tr>

            @forelse( $students as $student )
                <tr class="{{$student->tableClass}}">
                    <td>{{$student->name}}</td>
                    <td>{{$student->FormatedBirthday}}</td>
                    <td>
                        <a href="{{route('alunos.show', $student->slug)}}" class="permission btn btn-primary">
                            <i class="fa fa-user"></i>
                        </a>

                    </td>
                    <td>
                        {{$student->credits}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="90">
                        <p>Nenhum Resultado!</p>
                    </td>
                </tr>
            @endforelse
        </table>
        {{ $students->links() }}
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
