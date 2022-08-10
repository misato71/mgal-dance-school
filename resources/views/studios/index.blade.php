@extends('layouts.app')

@section('content')

    <h2>スタジオ一覧</h2>

    @if (count($studios) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>スタジオ名</th>
                    <th>画像</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($studios as $studio)
                <tr>
                    <td>{{ $studio->name }}</td>
                    <!--<td><img src="{{ asset('uploads')}}/{{$studio->image}}" alt="{{ $studio->image }}" class="studio-image"></td>-->
                    <td><img src="{{ Storage::disk('s3')->url('uploads/' . $studio->image) }}" alt="{{ $studio->image }}" class="studio-image"></td>
                    <td>{!! link_to_route('studios.show', '詳細', ['studio' => $studio->id], ['class' => 'btn btn-success']) !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    {{-- スタジオ作成ページへのリンク --}}
    {!! link_to_route('studios.create', 'スタジオ新規登録', [], ['class' => 'btn btn-primary']) !!}

@endsection
