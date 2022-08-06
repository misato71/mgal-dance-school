@if (count($errors) > 0)
    <ul class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error)
            <li class="ml-4">{{ $error }}</li>
        @endforeach
    </ul>
@endif

@if(session('warning'))
    <div class="alert alert-danger">
        {{ session('warning') }}
    </div>
@endif