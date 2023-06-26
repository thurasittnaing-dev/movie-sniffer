@extends('adminlte::page')

@section('title', 'Data Edit')

@section('content_header')
    <div class="card py-2 px-3 page-card">
        <div class="d-flex justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('movies.index') }}">Database</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Movie Edit</li>
                </ol>
            </nav>
        </div>
    </div>

@stop

@section('content')
    <div class="p-3">
        <div class="title">{{ $movie->title }} Edit</div>
        <form action="{{ route('movies.update', $movie->id) }}" method="POST" autocomplete="off">
            @csrf
            @method('PUT')


            <input type="hidden" name="page" value="{{ $page }}">
            <div class="form-card">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="text-primary" for="title">Movie Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Title" required
                            value="{{ $movie->title }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="text-primary" for="year">Year</label>
                        <input type="text" class="form-control" name="year" id="year" placeholder="Year"
                            value="{{ $movie->year }}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="text-primary" for="imdb_id">IMDB ID</label>
                        <input type="text" class="form-control" name="imdb_id" id="imdb_id" placeholder="IMDB ID"
                            value="{{ $movie->imdb_id }}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary" for="cm_url">Channel Myanmar URL</label>
                        <input type="text" class="form-control" name="cm_url" placeholder="URL" required
                            value="{{ $movie->cm_url }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary" for="poster">Poster Path</label>
                        <input type="text" class="form-control" name="poster" id="poster" placeholder="Poster URL"
                            value="{{ $movie->poster }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="text-primary">Description</label>
                        <textarea name="description" id="" rows="13" class="form-control">{{ $movie->description }}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-card">
                {{-- Links --}}
                @forelse ($download_links as $link)
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="text-primary">{{ $link->service }}</label>
                            <input type="text" name="link-{{ $link->id }}" value="{{ $link->url }}"
                                class="form-control">
                        </div>
                    </div>
                @empty
                @endforelse
            </div>

            <div class="form-group d-flex justify-content-end">
                <a href="{{ route('movies.index') }}" class="btn btn-theme bg-theme mr-2">Go Back</a>
                <button type="submit" class="btn btn-theme bg-theme">Update Info</button>
            </div>

        </form>
    </div>
@stop

@section('css')
    <style>
        .title {
            font-weight: bold;
            opacity: 0.7;
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }

        .form-card {
            border: 1px solid rgba(0, 0, 0, 0.4);
            border-radius: 0.35rem;
            padding: 1rem;
            margin-bottom: 2rem;
        }
    </style>
@stop

@section('js')

@stop
