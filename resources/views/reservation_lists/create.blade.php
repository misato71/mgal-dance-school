@extends('layouts.app')

@section('content')
    
    <h2>予約新規追加</h2>
    <p>こんにちは、{{ Auth::user()->name }}さん</p>
   
    
    {!! Form::open(['route' => 'reservation-lists.search', 'method' => 'get']) !!}
        <i class="fas fa-search"></i>{!! Form::label('user', '会員お客様検索（必須）') !!}
        <div class="input-group">
            
            <input type="text" class="form-control" placeholder="お名前又は電話番号を入力" name="keyword">
            <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fas fa-search"></i> 検索</button>
        </div>
    {!! Form::close() !!}
    
    {!! Form::model($reservation_list, ['route' => 'reservation-lists.store']) !!}
        
        @if (count($users) > 0)
            <h5><i class="fas fa-user-check"></i>お客様を選択してください(必須）</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>名前</th>
                        <th>フリガナ</th>
                        <th>電話番号</th>
                        <th>選択</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->kana_name}}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ Form::radio('user_id', $user->id, true) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        
            @if (count($lesson_schedules) > 0)
                <h5><i class="far fa-calendar-check"></i>予約するレッスンを選択してください(必須）</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>日付</th>
                            <th>時間</th>
                            <th>レッスン</th>
                            <th>残り予約枠</th>
                            <th>選択</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lesson_schedules as $lesson_schedule)
                        <tr>
                            <td>{{ $lesson_schedule->date }}</td>
                            <td>{{ $lesson_schedule->start_time }}～{{ $lesson_schedule->finish_time }}</td>
                            <td>{{ $lesson_schedule->lesson->name}}</td>
                            <td>残り{{ $lesson_schedule->reservation_limit }}席</td>
                            <td>{{ Form::radio('lesson_schedule_id', $lesson_schedule->id, true) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- ページネーションのリンク --}}
                {{ $lesson_schedules->links() }}
            @endif
            {!! Form::submit('予約する', ['class' => 'btn btn-primary btn-block']) !!}
        @endif
    {!! Form::close() !!}
    
    {{-- もどるのリンク --}}
    {!! link_to_route('lesson-schedules.index', 'もどる', [], ['class' => 'btn btn-secondary btn-lg btn-block']) !!}
@endsection