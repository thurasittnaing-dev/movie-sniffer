@extends('adminlte::page')

@section('title', 'Data Create')

@section('content_header')
    <div class="card py-2 px-3 page-card">
        <div class="d-flex justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('movies.index') }}">Database</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Create</li>
                </ol>
            </nav>
        </div>
    </div>

@stop

@section('content')
    <div class="card p-3">
        <form action="" autocomplete="off" id="submit-form">
            @csrf
            <div class="form-group">
                <label for="urls">Movie URL :</label>
                <textarea name="urls" id="urls" rows="6" class="form-control"></textarea>
                <small id="emailHelp" class="form-text text-muted">Just enter line by line for multiple urls.</small>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-theme bg-theme" id="fetch-btn">
                    <span id="btn-text">Fetch URLs</span>
                    <span id="loading"><i class="fas fa-circle-notch fa-spin"></i> Fetching ... </span>
                </button>
            </div>
        </form>
    </div>

    <div class="card p-3" id="fetch-result">
        <div class="mb-3">
            <span class="badge bg-theme py-1 px-3">Fetch Result</span>
        </div>
        <table class="table table-sm">
            <thead class="bg-theme table-bordered">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">IMDB ID</th>
                    <th scope="col">Result</th>
                </tr>
            </thead>
            <tbody id="tbody">
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <style>

    </style>
@stop

@section('js')
    <script>
        // init 
        $('#loading').hide();
        $('#fetch-result').hide();

        $(document).ready(function() {

            // on click
            $('#fetch-btn').on('click', function() {
                $('#tbody').empty();
                $(this).prop('disabled', true);
                $('#loading').show();
                $('#btn-text').hide();

                let urls = $('#urls').val();


                // console.log('here', urls);

                if (urls == "") {
                    $('#urls').addClass('is-invalid');
                    $('#urls').removeClass('is-valid');

                    $('#fetch-btn').prop('disabled', false);
                    $('#loading').hide();
                    $('#btn-text').show();
                    return false;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('movies.store') }}",
                    data: {
                        urls: urls,
                    },
                    success: function(response) {

                        $('#urls').val("");

                        if (response.status) {

                            // success init
                            $('#fetch-btn').prop('disabled', false);
                            $('#loading').hide();
                            $('#btn-text').show();
                            $('#fetch-result').show();

                            let i = 0;
                            response.result.forEach(data => {
                                i++;

                                let element = ` <tr>
                                              <th scope="row">${i}</th>
                                              <td>${data.title}</td>
                                              <td>${data.imdb_id}</td>
                                              <td>${data.result}</td>
                                          </tr>`;
                                $('#tbody').append(element);
                            });


                        }
                    }
                });

            });

            // on input change
            $('#urls').on('input', function() {
                if ($(this).val() != '') {
                    $('#urls').addClass('is-valid');
                    $('#urls').removeClass('is-invalid');
                } else {
                    $('#urls').addClass('is-invalid');
                    $('#urls').removeClass('is-valid');
                }
            });
        });
    </script>
@stop
