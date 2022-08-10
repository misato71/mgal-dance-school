@extends('layouts.app')

@section('content')
    
    <h2>スケジュール詳細</h2>
    
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
        @if (Auth::user()->is_admin == false)
            <?php $exist = ''; ?>
            @foreach (Auth::user()->reservation_lists as $reservation_list)
                @if ($reservation_list->lesson_schedule_id == $lesson_schedule->id)
                    @if ($reservation_list->status == 1)
                        <h3>※こちらの予約は予約済みです</h3>
                        <?php $exist = true; ?>
                    @endif
                @endif
            @endforeach
            
            @if ($lesson_schedule->reservation_limit <= 0 || $exist == true || $lesson_schedule->date < $today)
                <button type="button" class="btn btn-lg btn-block btn-warning" disabled>受付しておりません</button>
            @elseif ($lesson_schedule->reservation_limit >= 1)
                {{-- 予約作成ページへのリンク --}}
                {!! link_to_route('reservations.create', '予約する', ['id' => $lesson_schedule->id], ['class' => 'btn btn-primary btn-lg btn-block']) !!}    
                
            @endif
        @endif
        @if (Auth::user()->is_admin)
            {{-- スケジュール編集フォーム --}}
            {!! link_to_route('lesson-schedules.edit', '編集', ['lesson_schedule' => $lesson_schedule->id], ['class' => 'btn btn-warning btn-lg btn-block']) !!}
            
            {{-- スケジュール削除フォーム --}}
            <!--{!! Form::model($lesson_schedule, ['route' => ['lesson-schedules.destroy', $lesson_schedule->id], 'method' => 'delete']) !!}-->
            <!--    {!! Form::submit('削除', ['class' => 'btn btn-danger btn-block']) !!}-->
            <!--{!! Form::close() !!}-->
        @endif 
        {{-- もどるのリンク --}}
        {!! link_to_route('lesson-schedules.index', 'もどる', [], ['class' => 'btn btn-secondary btn-lg btn-block']) !!}
    </div>
        
@endsection