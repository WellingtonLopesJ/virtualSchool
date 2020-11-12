@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <div class="container">
        <h1 class="title">
            {{$student->name}}
        </h1>

        <div>
            <a href="{{route('balance.deposit', $student->slug)}}" class="btn btn-success">Adicionar saldo</a>
        </div>

        <div>
            <p><b>Data de nascimento:</b> {{$student->formatedBirthday}}</p>
            <p><b>Saldo:</b> {{$student->credits}}</p>
        </div>

        <hr>
        <table class="table table-hover table-bordered">

            @include('layouts.showResponse')


            <h3>Aulas</h3>
            <tr>
                <th>Data</th>
                <th>Local</th>
                <th width="150px">Ações</th>
            </tr>

            @forelse( $lessons as $lesson )
                <tr>
                    <td>{{$lesson->formatedDate}}</td>
                    <td>{{$lesson->address}}</td>
                    <td>
                        <form action="{{--{{route('tenants.remove_user')}}--}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
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

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
