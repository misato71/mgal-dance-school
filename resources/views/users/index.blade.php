@extends('layouts.app')

@section('content')
    
    <h1>お客様管理</h1>
    
    {!! Form::open(['route' => 'users.search', 'method' => 'get']) !!}
        <div class="input-group">
            <input type="text" class="form-control" placeholder="名前を入力" name="keyword">
            <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fas fa-search"></i> 検索</button>
        </div>
    {!! Form::close() !!}
    
    <p>こんにちは、{{ Auth::user()->name }}さん</p>
    
    @if (count($users) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>名前</th>
                    <th>フリガナ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->kana_name}}</td>
                    <td>{!! link_to_route('users.show', '詳細', ['user' => $user->id], ['class' => 'btn btn-success']) !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @endif
    
@endsection