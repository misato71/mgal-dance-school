@extends('layouts.app')

@section('content')

    <h1>スタジオ一覧</h1>

    @if (count($studios) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>スタジオ名</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($studios as $studio)
                <tr>
                    <td>{{ $studio->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    {{-- スタジオ作成ページへのリンク --}}
    {!! link_to_route('studios.create', '新規登録', [], ['class' => 'btn btn-primary']) !!}

@endsection
