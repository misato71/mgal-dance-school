@extends('layouts.app')

@section('content')
    <div class="center jumbotron">
        <div class="text-center">
            @if (Auth::check())
                {{ Auth::user()->name }}
            @else
                <h1>Welcome to the Mgal Dance School</h1>
                {{-- ユーザ登録ページへのリンク --}}
                {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
            @endif
        </div>
    </div>
@endsection
