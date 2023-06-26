@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Movie List</li>
            </ol>
        </nav>
        <div>
            <a href="{{ route('movies.create') }}" class="btn btn-sm bg-theme">Fetch New</a>
        </div>
    </div>
@stop

@section('content')
    <div>
        @php
            $page = $_GET['page'] ?? 1;
            $keyword = $_GET['keyword'] ?? '';
            $year = $_GET['year'] ?? '';
            $status = $_GET['status'] ?? '';
        @endphp

        <div class="d-flex justify-content-center">
            <form action="" autocomplete="off" class="col-md-6">
                <div class="input-group mb-3">
                    <input type="text" name="keyword" class="form-control" placeholder="Search..."
                        value="{{ $keyword }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary bg-theme" type="button" data-toggle="modal"
                            data-target="#filterModal">More Filter</button>
                    </div>
                </div>
            </form>

            <!-- Modal -->
            <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="" method="GET" autocomplete="off">
                            <input type="hidden" name="keyword" value="{{ $keyword }}">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">More Filter</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Year</label>
                                        <input type="number" name="year" class="form-control" placeholder="Year"
                                            value="{{ $year }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Status</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="">All</option>
                                            <option value="1" {{ $status == '1' ? 'selected' : '' }}>Verified</option>
                                            <option value="0" {{ $status == '0' ? 'selected' : '' }}>Not Verify
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary bg-theme">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-2">Total : {{ $total }}</div>
        <table class="table table-sm">
            <thead class="bg-theme">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">IMDB ID</th>
                    <th scope="col">Year</th>
                    <th scope="col">CM URL</th>
                    <th scope="col">Status</th>
                    <th scope="col" align="center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($movies as $movie)
                    <tr>
                        <td>{{ ++$i }}.</td>
                        <td>{{ $movie->title }}</td>
                        <td>{{ $movie->imdb_id }}</td>
                        <td>
                            <span class="badge bg-theme">{{ $movie->year }}</span>
                        </td>
                        <td>
                            <a href="{{ $movie->cm_url }}" class="btn btn-sm btn-link" target="_blank">URL</a>
                        </td>
                        <td>
                            @if ($movie->verified)
                                <span class="badge badge-success">Verified</span>
                            @else
                                <span class="badge badge-warning">Not Verify</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="" class="btn btn-sm btn-info">
                                    <small>Info</small>
                                </a>
                                <a href="{{ route('movies.edit', $movie->id . '-' . $page) }}"
                                    class="btn btn-sm btn-primary">
                                    <small>Edit</small>
                                </a>
                                <a href="" class="btn btn-sm btn-danger">
                                    <small>Delete</small>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        {!! $movies->appends(request()->input())->links() !!}
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
