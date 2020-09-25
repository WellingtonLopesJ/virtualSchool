@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <div class="container">

        @include('layouts.showResponse')

        <form action="{{route('roles.store_permission', $role->id)}}" method="POST">

            @csrf

            <header><h3>Adicionar permissão para {{$role->name}}</h3></header>

            <div class="form-group">
                <label for="permissions">Permissão</label>

                <select class="form-control" id="permissions" name="permissionId">
                    @forelse($permissions as $permission)
                    <option value="{{$permission->id}}">{{$permission->id}} - {{$permission->name}}</option>
                    @empty

                    @endforelse
                </select>

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
