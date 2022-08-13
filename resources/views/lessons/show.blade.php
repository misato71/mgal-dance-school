@extends('layouts.app')

@section('content')
    
    <h2>レッスン詳細</h2>
    <div class="center">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $lesson->name }}</h3>
                
            </div>
            <div class="card-body">
                <p class="mb-0">{!! nl2br(e($lesson->comment)) !!}</p>
            </div>
        </div>
        @if (Auth::user()->is_admin)
            {{-- レッスン編集フォーム --}}
            {!! link_to_route('lessons.edit', '編集', ['lesson' => $lesson->id], ['class' => 'btn btn-warning btn-lg btn-block']) !!}
            
        @endif 
        {{-- もどるのリンク --}}
        {!! link_to_route('lessons.index', 'もどる', [], ['class' => 'btn btn-secondary btn-lg btn-block']) !!}
    </div>
        
@endsection