@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>登録情報の変更</h1>
        <p>{{ $user->name }}さんの登録情報</p>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'put']) !!}
                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('name', 'お名前') !!}
                    {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('kana_name', 'フリガナ') !!}
                    {!! Form::text('kana_name', $user->kana_name, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('birthday', 'お誕生日') !!}
                    {!! Form::date('birthday', $user->birthday, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('phone', '電話番号（半角数字、ハイフンなし）') !!}
                    {!! Form::text('phone', $user->phone, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('zipcode', '郵便番号（半角数字、ハイフンなし）') !!}
                    {!! Form::text('zipcode', $user->zipcode, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('address', '住所') !!}
                    {!! Form::text('address', $user->address, ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('変更する', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
            {{-- もどるのリンク --}}
            {!! link_to_route('lesson-schedules.index', 'もどる', [], ['class' => 'btn btn-secondary btn-block']) !!}
        </div>
        
    </div>
    
@endsection