@extends('layouts.app')

@section('content')
    
    <h1>予約内容</h1>
    @if ($reservation_list->status == 0)
        <h2>※こちらの予約はキャンセル済みです。</h2>
    @endif
    <div class="center">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $reservation_list->lesson_schedule->lesson->name }}</h3>
                <p>
                    <i class="far fa-calendar-alt"></i>{{ $reservation_list->lesson_schedule->date }}
                    <i class="far fa-clock"></i>{{ $reservation_list->lesson_schedule->start_time }}～{{ $reservation_list->lesson_schedule->finish_time }}
                </p>
            </div>
            <div class="card-body">
                <p>{{ $reservation_list->lesson_schedule->lesson->comment }}</p>
                <h5><i class="fas fa-user-friends"></i>{{ $reservation_list->lesson_schedule->instructor->name }}</h5>
                <h5><i class="far fa-building"></i>{{ $reservation_list->lesson_schedule->studio->name }}</h5>
            </div>
        </div>
        @if ($reservation_list->status == 1)
            {{-- 予約キャンセルページへのリンク --}}
            {!! Form::open(['route' => ['reservations.update', ['reservation_list' => $reservation_list->id]], 'method' => 'put']) !!}
                {!! Form::submit('キャンセルする', ['class' => 'btn btn-danger btn-lg btn-block']) !!}
            {!! Form::close() !!}
        @elseif ($reservation_list->status == 0)
            <button type="button" class="btn btn-lg btn-block btn-warning" disabled>こちらの予約はキャンセル済み</button>
        @endif
        {{-- もどるのリンク --}}
        {!! link_to_route('reservations', 'もどる', [], ['class' => 'btn btn-secondary btn-lg btn-block']) !!}
    </div>
        
@endsection