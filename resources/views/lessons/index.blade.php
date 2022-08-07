@extends('layouts.app')

@section('content')

    <h2>レッスン一覧</h2>

    @if (count($lessons) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>レッスン名</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lessons as $lesson)
                <tr>
                    <td>{{ $lesson->name }}</td>
                    <td>{!! link_to_route('lessons.show', '詳細', ['lesson' => $lesson->id], ['class' => 'btn btn-success']) !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    {{-- レッスン作成ページへのリンク --}}
    {!! link_to_route('lessons.create', 'レッスン新規登録', [], ['class' => 'btn btn-primary']) !!}

@endsection
