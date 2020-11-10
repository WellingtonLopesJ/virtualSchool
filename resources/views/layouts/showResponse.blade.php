
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>
                    {{$error}}
                </li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success my-3">
        {{session()->get('success')}}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger my-3">
        {{session()->get('error')}}
    </div>
@endif


