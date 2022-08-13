@extends('layouts.app')

@section('content')

    <h2>スケジュール一覧</h2>
    
    {!! Form::open(['route' => 'lesson-schedules.search', 'method' => 'get']) !!}
        <div class="input-group">
            <input type="date" class="form-control" placeholder="レッスン日を入力" name="keyword">
            <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fas fa-search"></i> 検索</button>
        </div>
    {!! Form::close() !!}

    @if (count($lesson_schedules) > 0)
        
        <h3>{{ $year }} 年{{ $month }}月～</h3>
        
        @if ($next_month == null)
            {!! link_to_route('lesson-schedules.index', '今月', [], ['class' => 'btn btn-link']) !!}
        @else
        {!! link_to_route('lesson-schedules.next_month', '翌月', ['next_month' => $next_month], ['class' => 'btn btn-link']) !!}
        @endif
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>日付</th>
                    <th>時間</th>
                    <th>レッスン</th>
                    <th>残り予約枠</th>
                    <th>予約</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lesson_schedules as $lesson_schedule)
                <tr>
                    <td>{{ $lesson_schedule->date }}</td>
                    <td>{{ $lesson_schedule->start_time }}～{{ $lesson_schedule->finish_time }}</td>
                    <td>{{ $lesson_schedule->lesson->name}}</td>
                    
                    @if ($lesson_schedule->date < $today)
                        <td>受付終了</td>
                    @elseif ($lesson_schedule->reservation_limit == 0)
                        <td>満席</td>
                    @else
                        <td>残り{{ $lesson_schedule->reservation_limit }}席</td>
                    @endif
                    <td>{!! link_to_route('lesson-schedules.show', '詳細', ['lesson_schedule' => $lesson_schedule->id], ['class' => 'btn btn-success']) !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- ページネーションのリンク --}}
        {{ $lesson_schedules->links() }}
    @else
        <div class="text-center">
            <h3>該当するスケジュールが見つかりませんでした</h3>
        </div>
        {{-- もどるのリンク --}}
        {!! link_to_route('lesson-schedules.index', 'もどる', [], ['class' => 'btn btn-secondary btn-lg btn-block']) !!}
    @endif
    
    @if (Auth::user()->is_admin)
        {{-- スケジュール作成ページへのリンク --}}
        {!! link_to_route('lesson-schedules.create', 'スケジュール新規登録', [], ['class' => 'btn btn-primary']) !!}
    
        {{-- 予約新規追加リンク --}}
        {!! link_to_route('reservation-lists.create', '予約新規追加', [], ['class' => 'btn btn-dark']) !!}
        
    @endif
    
@endsection
