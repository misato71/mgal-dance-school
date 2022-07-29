@extends('layouts.app')

@section('content')

    <h1>スケジュール新規登録</h1>

    <div class="row">
        <div class="col-6">
            {!! Form::model($lesson_schedule, ['route' => 'lesson-schedules.store']) !!}
                
                <div class="form-group">
                    {!! Form::label('date', 'レッスン日（必須）') !!}
                    {!! Form::date('date', null, ['class' => 'form-control']) !!}
                </div>
            
                <div class="form-group">
                    {!! Form::label('lesson_id', 'レッスン名（必須）') !!}
                    <select name="lesson_id" class="custom-select form-control">
                     <option value="lesson_id">選択してください</option>
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    {!! Form::label('start_time', '開始時間（必須）') !!}
                    {!! Form::text('start_time', null, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('finish_time', '終了時間（必須）') !!}
                    {!! Form::text('finish_time', null, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('instructor_id', '担当講師（必須）') !!}
                    <select name="instructor_id" class="custom-select form-control">
                     <option value="instructor_id">選択してください</option>
                        @foreach($instructors as $instructor)
                            <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    {!! Form::label('reservation_limit', '予約できる人数（必須）') !!}
                    {!! Form::text('reservation_limit', null, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('studio_id', 'スタジオ（必須）') !!}
                    <select name="studio_id" class="custom-select form-control">
                     <option value="studio_id">選択してください</option>
                        @foreach($studios as $studio)
                            <option value="{{ $studio->id }}">{{ $studio->name }}</option>
                        @endforeach
                    </select>
                </div>

                {!! Form::submit('登録する', ['class' => 'btn btn-primary']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection