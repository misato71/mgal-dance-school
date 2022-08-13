@extends('layouts.app')

@section('content')
    
    <h2>予約管理</h2>
    <p>こんにちは、{{ Auth::user()->name }}さん</p>
    
    @if (count($reservation_lists) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>日付</th>
                    <th>時間</th>
                    <th>レッスン</th>
                    <th>ステータス</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservation_lists as $reservation_list)
                <tr>
                    <td>{{ $reservation_list->lesson_schedule->date }}</td>
                    <td>{{ $reservation_list->lesson_schedule->start_time }}～{{ $reservation_list->lesson_schedule->finish_time }}</td>
                    <td>{{ $reservation_list->lesson_schedule->lesson->name}}</td>
                    @if ($reservation_list->status == 0)
                        <td>キャンセル済み</td>
                    @elseif ($reservation_list->lesson_schedule->date < $today)
                        <td>受講済み</td>
                    @else
                        <td>予約中</td>
                    @endif
                    <td>{!! link_to_route('reservations.show', '予約内容', ['id' => $reservation_list->id], ['class' => 'btn btn-success']) !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- ページネーションのリンク --}}
        {{ $reservation_lists->links() }}
    @else
        <div class="text-center">
            <h3>予約がありません</h3>
        </div>
        {{-- もどるのリンク --}}
        {!! link_to_route('lesson-schedules.index', 'ホーム', [], ['class' => 'btn btn-secondary btn-lg btn-block']) !!}
    @endif
    
@endsection