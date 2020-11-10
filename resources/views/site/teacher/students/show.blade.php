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

        <table class="table table-hover">
            @include('layouts.showResponse')

            <div>
                <p>Data de nascimento: {{$student->formatedBirthday}}</p>
                <p>Saldo: {{$student->credits}}</p>
            </div>

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
                            <input type="hidden" name="tenantId" value="{{$tenant->id}}">
                            <input type="hidden" name="userId" value="{{$lesson->id}}">
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
