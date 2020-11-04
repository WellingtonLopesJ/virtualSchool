@extends('layouts.app')

@section('content')

    <h1>Listagem dos posts</h1>

    @forelse($posts as $post)
        <h3><a href="{{route('posts.show', $post->id)}}">{{$post->title}}</a></h3> <br>
        <p>{{$post->body}}</p>
        <b>Author: {{$post->user->name}}</b>
        @can('edit-post')
            <a href="{{route('posts.edit', $post->id)}}">Editar</a>
        @endcan

        @can('delete-post')
            <form action="{{route('posts.destroy', $post->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Excluir</button>
            </form>
        @endcan
        <hr>
    @empty
        <h3>Nenhum post!</h3>
    @endforelse

@endsection
