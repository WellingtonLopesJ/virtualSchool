@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <div class="container" >
        <h1 class="title">
            Lessons list
        </h1>
        @include('layouts.showResponse')
        <a href="{{route('aulas.create')}}" class="btn btn-primary">Criar Lesson</a>

        @include('layouts.calendar')


        <table class="table table-hover">

            <tr>
                <th>id</th>
                <th>Location</th>
                <th>date</th>
            </tr>

            @forelse( $lessons as $lesson )
                <tr>
                    <td>{{$lesson->id}}</td>
                    <td>{{$lesson->location->address ?? "nothing"}}</td>
                    <td>{{$lesson->date}}</td>
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
