@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>AdminController index</p>
    <a href="{{route('roles.index')}}" class="btn btn-primary">Roles</a>
    <a href="{{route('permissions.index')}}" class="btn btn-primary">Permissions</a>
    <a href="{{route('tenants.index')}}" class="btn btn-primary">Tenants</a>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
