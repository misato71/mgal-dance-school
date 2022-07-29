@extends('layouts.app')

@section('content')

    <h1>スタジオ新規登録</h1>

    <div class="row">
        <div class="col-6">
            {!! Form::model($studio, ['route' => 'studios.store']) !!}
            
                <div class="form-group">
                    {!! Form::label('name', 'スタジオ名（必須）') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('image', '画像') !!}
                    {!! Form::file('image', null, ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('登録する', ['class' => 'btn btn-primary']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection