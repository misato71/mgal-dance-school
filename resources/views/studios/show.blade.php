@extends('layouts.app')

@section('content')
    
    <h2>スタジオ詳細</h2>
    <div class="center">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $studio->name }}</h3>
                
            </div>
            <div class="card-body">
                <img src="{{ Storage::disk('s3')->url('uploads/' . $studio->image) }}" alt="{{ $studio->image }}" class="studio-image rounded mx-auto d-block img-thumbnail">
            </div>
        </div>
        @if (Auth::user()->is_admin)
            {{-- レッスン編集フォーム --}}
            {!! link_to_route('studios.edit', '編集', ['studio' => $studio->id], ['class' => 'btn btn-warning btn-lg btn-block']) !!}
            
        @endif 
        {{-- もどるのリンク --}}
        {!! link_to_route('studios.index', 'もどる', [], ['class' => 'btn btn-secondary btn-lg btn-block']) !!}
    </div>
        
@endsection