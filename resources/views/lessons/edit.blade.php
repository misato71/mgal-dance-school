@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h2>レッスン編集</h2>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            {!! Form::model($lesson, ['route' => ['lessons.update', $lesson->id], 'method' => 'put']) !!}
            
                <div class="form-group">
                    {!! Form::label('name', 'レッスン名（必須）') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('comment', 'コメント（必須）') !!}
                    {!! Form::textarea('comment', null, ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('更新する', ['class' => 'btn btn-primary btn-block']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection