@extends('layouts.app')

@section('content')
    <div class="center jumbotron">
        <div class="text-center">
            @if (Auth::check())
                {{ Auth::user()->name }}
            @else
                <h1>Welcome to the Mgal Dance School</h1>
            @endif
        </div>
    </div>
@endsection
