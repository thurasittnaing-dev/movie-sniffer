@extends('adminlte::page')

@section('title', 'Database')

@section('content_header')
    <div class="card py-2 px-3 page-card">
        <div class="d-flex justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Movie List</li>
                </ol>
            </nav>
        </div>
    </div>

@stop

@section('content')
    <div class="">
        <div class="movie-container">
            @forelse ($movies as $movie)
                <div class="movice-card">
                    <img src="{{ asset('storage/posters/') . '/' . $movie->poster }}" class="movie-poster" alt="">
                    <span class="year-badge">{{ $movie->year }}</span>
                    <div class="movie-title">{{ $movie->title }}</div>
                </div>
            @empty
            @endforelse
        </div>
        <div class="mt-5">
            {!! $movies->appends(request()->input())->links() !!}
        </div>
    </div>
@stop

@section('css')
    <style>

    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {

        });
    </script>
@stop
