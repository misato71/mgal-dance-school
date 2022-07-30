@extends('layouts.app')

@section('content')

    <h1>レッスン新規登録</h1>

    <div class="row">
        <div class="col-6">
            {!! Form::model($lesson, ['route' => 'lessons.store']) !!}
            
                <div class="form-group">
                    {!! Form::label('name', 'レッスン名（必須）') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('comment', '内容（必須）') !!}
                    {!! Form::textarea('comment', null, ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('登録する', ['class' => 'btn btn-primary']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection