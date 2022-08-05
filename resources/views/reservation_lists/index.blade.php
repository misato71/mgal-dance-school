@extends('layouts.app')

@section('content')
    
    <h1>予約一覧</h1>
    
    @if (count($lesson_schedules) > 0)
        @foreach ($lesson_schedules as $lesson_schedule)
            
            <h5><i class="far fa-calendar-alt"></i>{{ $lesson_schedule->date }}
            <i class="far fa-clock"></i>{{ $lesson_schedule->start_time }}～{{ $lesson_schedule->finish_time }}</h5>
            <p><i class="fas fa-chalkboard"></i>{{ $lesson_schedule->lesson->name}}<i class="fas fa-user-friends"></i>{{ $lesson_schedule->instructor->name}}</p>
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ステータス</th>
                        <th>お客様id</th>
                        <th>お客様名前</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lesson_schedule->reservation_lists as $reservation_list)
                    <tr>
                        @if ($reservation_list->status == 0)
                            <td>キャンセル済み</td>
                        @elseif ($reservation_list->status == 1)
                            <td>予約中</td>
                        @endif
                        <td>{{ $reservation_list->user->id }}</td>
                        <td>{{ $reservation_list->user->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
        {{-- ページネーションのリンク --}}
        {{ $lesson_schedules->links() }}
    @endif
    
@endsection