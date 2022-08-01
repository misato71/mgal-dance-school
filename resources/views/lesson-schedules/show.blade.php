@extends('layouts.app')

@section('content')
    
    <h1>スケジュール詳細</h1>
    
    <div class="center">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $lesson_schedule->lesson->name }}</h3>
                <p>
                    <i class="far fa-calendar-alt"></i>{{ $lesson_schedule->date }}
                    <i class="far fa-clock"></i>{{ $lesson_schedule->start_time }}～{{ $lesson_schedule->finish_time }}
                </p>
            </div>
            <div class="card-body">
                <p>{{ $lesson_schedule->lesson->comment }}</p>
                <h5><i class="fas fa-user-friends"></i>{{ $lesson_schedule->instructor->name }}</h5>
                <img src="{{ asset('uploads')}}/{{$lesson_schedule->instructor->image}}" alt="{{ $lesson_schedule->instructor->image }}" class="instructor-icon">
                <p>{{ $lesson_schedule->instructor->comment }}</p>
                <h5><i class="far fa-building"></i>{{ $lesson_schedule->studio->name }}</h5>
                <img src="{{ asset('uploads')}}/{{$lesson_schedule->studio->image}}" alt="{{ $lesson_schedule->studio->image }}" class="studio-image">
            </div>
        </div>
        
        {{-- 予約作成ページへのリンク --}}
        {!! link_to_route('reservations.create', '予約する', ['id' => $lesson_schedule->id], ['class' => 'btn btn-primary btn-lg btn-block']) !!}
        {{-- もどるのリンク --}}
        {!! link_to_route('lesson-schedules.index', 'もどる', [], ['class' => 'btn btn-secondary btn-lg btn-block']) !!}
    </div>
        
@endsection