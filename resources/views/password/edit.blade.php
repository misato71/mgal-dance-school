@extends('layouts.app')

@section('content') 
    <div class="text-center">
        <h2>パスワード変更</h2>
    </div>

    <div class="row mt-5 mb-5">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::open(['route'=>'password.change','method'=>'put']) !!}
                <div class="form-group">
                    {!! Form::label('current_password','以前のPassword') !!}
                    {!! Form::password('current_password',['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('new_password','新しいPassword（8文字以上）') !!}
                    {!! Form::password('new_password',['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('new_password_confirmation','Password 確認') !!}
                    {!! Form::password('new_password_confirmation',['class'=>'form-control']) !!}
                </div>

                {!! Form::submit('パスワードを更新する',['class'=>'btn btn btn-primary mt-2']) !!}
            {!! Form::close() !!}

        </div>
    </div>
@endsection