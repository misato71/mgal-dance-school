@extends('layouts.app')

@section('content')
    
    <h2>お客様情報詳細</h2>
    
    <table class="table table-striped table-bordered">
        <tbody>
            <tr>
                <th>会員ID</th>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <th>名前</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>フリガナ</th>
                <td>{{ $user->kana_name}}</td>
            </tr>
            <tr>
                <td>電話番号</td>
                <td>{{ $user->phone }}</td>
            </tr>
            <tr>
                <th>email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>誕生日</th>
                <td>{{ $user->birthday }}</td>
            </tr>
            <tr>
                <th>郵便番号</th>
                <td>〒{{ $user->zipcode }}</td>
            </tr>
            <tr>
                <th>住所</th>
                <td>{{ $user->address }}</td>
            </tr>
        </tbody>
    </table>
    
    {{-- もどるのリンク --}}
    {!! link_to_route('users.index', 'もどる', [], ['class' => 'btn btn-secondary btn-lg btn-block']) !!}
    
@endsection