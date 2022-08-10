@extends('layouts.app')

@section('content')
    
    <h2>予約内容確認</h2>
    
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
                <img src="{{ Storage::disk('s3')->url('uploads/' . $lesson_schedule->instructor->image) }}" alt="{{ $lesson_schedule->instructor->image }}" class="instructor-icon">
                <p>{{ $lesson_schedule->instructor->comment }}</p>
                <h5><i class="far fa-building"></i>{{ $lesson_schedule->studio->name }}</h5>
                <img src="{{ Storage::disk('s3')->url('uploads/' . $lesson_schedule->studio->image) }}" alt="{{ $lesson_schedule->studio->image }}" class="studio-image">
            </div>
        </div>
        
        @if ($lesson_schedule->reservation_limit >= 1)
            {{-- 予約作成ページへのリンク --}}
            {!! Form::open(['route' => ['reservations.store', ['lesson_schedule_id' => $lesson_schedule->id, 'user_id' => Auth::user()->id]], 'method' => 'post']) !!}
                {!! Form::submit('予約を登録する', ['class' => 'btn btn-primary btn-lg btn-block']) !!}
            {!! Form::close() !!}
        @elseif ($lesson_schedule->reservation_limit <= 0)
            <button type="button" class="btn btn-lg btn-block btn-warning" disabled>受付しておりません</button>
        @endif
        
        {{-- もどるのリンク --}}
        {!! link_to_route('lesson-schedules.index', 'もどる', [], ['class' => 'btn btn-secondary btn-lg btn-block']) !!}
    </div>
        
@endsection