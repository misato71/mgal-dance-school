@extends('layouts.app')

@section('content')
    
    <div class="text-center">
        <h3>登録完了</h3>
    
    {{-- ホームのリンク --}}
    {!! link_to_route('lesson-schedules.index', 'ホームへ', [], ['class' => 'btn btn-block btn-lg btn-outline-success']) !!}
    </div>
@endsection