@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>レッスン編集</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            {!! Form::model($lesson, ['route' => ['lessons.update', $lesson->id], 'method' => 'put']) !!}
            
                <div class="form-group">
                    {!! Form::label('name', 'レッスン名（必須）') !!}
                    {!! Form::text('name', $lesson->name, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('comment', '内容（必須）') !!}
                    {!! Form::textarea('comment', $lesson->comment, ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('編集する', ['class' => 'btn btn-primary btn-block']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection