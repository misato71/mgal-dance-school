@extends('layouts.app')

@section('content')
    
    <h1>予約一覧</h1>
    <p>こんにちは、{{ $user->name }}さん</p>
    
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
                    @elseif ($reservation_list->lesson_schedule->date < date("Y-m-d"))
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
    @endif
    
@endsection