@extends('layouts.app')

@section('content')
    
    <h2>予約管理</h2>
    
    {!! Form::open(['route' => 'reservations.search', 'method' => 'get']) !!}
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">レッスン日を入力してください</span>
            </div>
            <input type="date" class="form-control" placeholder="レッスン日を入力" name="keyword">
            <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fas fa-search"></i> 検索</button>
        </div>
    {!! Form::close() !!}
    <hr>
    @if (count($lesson_schedules) > 0)
        
        @foreach ($lesson_schedules as $lesson_schedule)
            
            <h4>
                <i class="far fa-calendar-alt"></i>{{ $lesson_schedule->date }}
                <i class="far fa-clock"></i>{{ $lesson_schedule->start_time }}～{{ $lesson_schedule->finish_time }}
            </h4>
            
            <p><i class="fas fa-chalkboard"></i>{{ $lesson_schedule->lesson->name}}<i class="fas fa-user-friends"></i>{{ $lesson_schedule->instructor->name}}</p>
            
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>ステータス</th>
                        <th>お客様id</th>
                        <th>お客様名前</th>
                        <th>電話番号</th>
                        <th></th>
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
                        <td>{{ $reservation_list->user->phone }}</td>
                        <td>{!! link_to_route('reservation-lists.show', '予約詳細', ['reservation_list' => $reservation_list->id], ['class' => 'btn btn-success']) !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
        
    @else
        
        <div class="text-center">
            <h5>予約がありません</h5>
        </div>
        
        {{-- もどるのリンク --}}
        {!! link_to_route('reservations', 'もどる', [], ['class' => 'btn btn-secondary']) !!}
        
    @endif
    
    {{-- 予約新規追加リンク --}}
    {!! link_to_route('reservation-lists.create', '予約新規追加', [], ['class' => 'btn btn-primary']) !!}
    
@endsection