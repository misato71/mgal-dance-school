@extends('layouts.app')

@section('content')
    
    <h2>講師詳細</h2>
    <div class="center">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $instructor->name }}</h3>
                
            </div>
            <div class="card-body">
                <p>{{ $instructor->comment }}</p>
                <img src="{{ Storage::disk('s3')->url('uploads/' . $instructor->image) }}" alt="{{ $instructor->image }}" class="instructor-icon">
            </div>
        </div>
        @if (Auth::user()->is_admin)
            {{-- レッスン編集フォーム --}}
            {!! link_to_route('instructors.edit', '編集', ['instructor' => $instructor->id], ['class' => 'btn btn-warning btn-lg btn-block']) !!}
            
        @endif 
        {{-- もどるのリンク --}}
        {!! link_to_route('instructors.index', 'もどる', [], ['class' => 'btn btn-secondary btn-lg btn-block']) !!}
    </div>
        
@endsection