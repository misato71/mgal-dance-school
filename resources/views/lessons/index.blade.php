@extends('layouts.app')

@section('content')

    <h1>レッスン一覧</h1>

    @if (count($lessons) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>レッスン名</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lessons as $lesson)
                <tr>
                    <td>{{ $lesson->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    {{-- レッスン作成ページへのリンク --}}
    {!! link_to_route('lessons.create', '新規登録', [], ['class' => 'btn btn-primary']) !!}

@endsection
