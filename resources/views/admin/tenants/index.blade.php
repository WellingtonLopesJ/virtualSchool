@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
    <div class="container" >
        <h1 class="title">
            Tenants list
        </h1>


        <table class="table table-hover">
            @include('layouts.showResponse')
            <a href="{{route('tenants.create')}}" class="btn btn-primary">Criar tenant</a>
            <tr>
                <th>Name</th>
                <th>subdomain</th>
                <th width="150px">Usuários</th>
                <th width="150px">Excluir</th>
            </tr>

            @forelse( $tenants as $tenant )
                <tr>
                    <td>{{$tenant->name}}</td>
                    <td>{{$tenant->subdomain}}</td>
                    <td>
                        <a href="{{route('tenants.show', $tenant->id)}}" class="permission btn btn-primary">
                            <i class="fas fa-users"></i>
                        </a>


                    </td>
                    <td>
                        <form action="{{route('tenants.destroy', $tenant->id)}}" method="POST">
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
