@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h2>スタジオ新規登録</h2>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            {!! Form::model($studio, ['route' => 'studios.store', 'files' => true]) !!}
            
                <div class="form-group">
                    {!! Form::label('name', 'スタジオ名（必須）') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('image', '画像') !!}
                    {!! Form::file('image', null, ['class' => 'form-control']) !!}
                </div

                {!! Form::submit('登録する', ['class' => 'btn btn-primary btn-block']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection