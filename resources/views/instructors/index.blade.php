@extends('layouts.app')

@section('content')

    <h2>講師一覧</h2>

    @if (count($instructors) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>講師名</th>
                    <th>画像</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($instructors as $instructor)
                <tr>
                    <td>{{ $instructor->name }}</td>
                    <td><img src="{{ asset('uploads')}}/{{$instructor->image}}" alt="{{ $instructor->image }}" class="instructor-icon"></td>
                    <td>{!! link_to_route('instructors.show', '詳細', ['instructor' => $instructor->id], ['class' => 'btn btn-success']) !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    {{-- 講師作成ページへのリンク --}}
    {!! link_to_route('instructors.create', '講師新規登録', [], ['class' => 'btn btn-primary']) !!}

@endsection
