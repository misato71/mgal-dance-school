@extends('layouts.app')

@section('content')
    
    <h2>予約詳細</h2>
    @if ($reservation_list->status == 0)
        <h3>※こちらの予約はキャンセル済みです。</h3>
    @endif
    <h5><i class="fas fa-user-check"></i>お客様情報</h5>
    <table class="table table-striped table-bordered">
        <tbody>
            <tr>
                <th>会員ID</th>
                <td>{{ $reservation_list->user->id }}</td>
            </tr>
            <tr>
                <th>名前</th>
                <td>{{ $reservation_list->user->name }}</td>
            </tr>
            <tr>
                <th>フリガナ</th>
                <td>{{ $reservation_list->user->kana_name}}</td>
            </tr>
            <tr>
                <td>電話番号</td>
                <td>{{ $reservation_list->user->phone }}</td>
            </tr>
            <tr>
                <th>email</th>
                <td>{{ $reservation_list->user->email }}</td>
            </tr>
            <tr>
                <th>誕生日</th>
                <td>{{ $reservation_list->user->birthday }}</td>
            </tr>
        </tbody>
    </table>
    <h5><i class="far fa-calendar-check"></i>予約内容</h5>
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
                <p class="mb-0">{!! nl2br(e($reservation_list->lesson_schedule->lesson->comment)) !!}</p>
                <h5><i class="fas fa-user-friends"></i>{{ $reservation_list->lesson_schedule->instructor->name }}</h5>
                <img src="{{ Storage::disk('s3')->url('uploads/' . $reservation_list->lesson_schedule->instructor->image) }}" alt="{{ $reservation_list->lesson_schedule->instructor->image }}" class="instructor-icon">
                <p class="mb-0">{!! nl2br(e($reservation_list->lesson_schedule->instructor->comment)) !!}</p>
                <h5><i class="far fa-building"></i>{{ $reservation_list->lesson_schedule->studio->name }}</h5>
                <img src="{{ Storage::disk('s3')->url('uploads/' . $reservation_list->lesson_schedule->studio->image) }}" alt="{{ $reservation_list->lesson_schedule->studio->image }}" class="studio-image">
            </div>
        </div>
        @if ($reservation_list->status == 1)
            {{-- 予約キャンセルページへのリンク --}}
            {!! Form::open(['route' => ['reservation-lists.update', ['reservation_list' => $reservation_list->id]], 'method' => 'put']) !!}
                {!! Form::submit('キャンセルする', ['class' => 'btn btn-danger btn-lg btn-block']) !!}
            {!! Form::close() !!}
        @elseif ($reservation_list->status == 0)
            <button type="button" class="btn btn-lg btn-block btn-warning" disabled>こちらの予約はキャンセル済み</button>
        @endif
        {{-- もどるのリンク --}}
        {!! link_to_route('reservations', 'もどる', [], ['class' => 'btn btn-secondary btn-lg btn-block']) !!}
    </div>
        
@endsection