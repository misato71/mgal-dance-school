@extends('layouts.app')

@section('content')

    <h1>スケジュール一覧</h1>

    @if (count($lesson_schedules) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>日付</th>
                    <th>時間</th>
                    <th>レッスン</th>
                    <th>残り予約枠</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lesson_schedules as $lesson_schedule)
                <tr>
                    <td>{{ $lesson_schedule->date }}</td>
                    <td>{{ $lesson_schedule->start_time }}～{{ $lesson_schedule->finish_time }}</td>
                    <td>{{ $lesson_schedule->lesson->name}}</td>
                    @if ($lesson_schedule->reservation_limit == 0)
                        <td>満席</td>
                    @else
                        <td>残り{{ $lesson_schedule->reservation_limit }}席</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- ページネーションのリンク --}}
        {{ $lesson_schedules->links() }}
    @endif
    
    {{-- スケジュール作成ページへのリンク --}}
    {!! link_to_route('lesson-schedules.create', 'スケジュール新規登録', [], ['class' => 'btn btn-primary']) !!}

@endsection
