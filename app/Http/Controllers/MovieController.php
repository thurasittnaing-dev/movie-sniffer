<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use App\Models\DownloadLink;
use App\Services\MovieService;


class MovieController extends Controller
{
    // Movie Index Function
    public function index(Request $request, MovieService $movieService)
    {
        // Get Movie Data
        [$movies, $total] = $movieService->getData($request, 10);
        return view('backend.movies.index', compact('movies', 'total'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    // CM Movies Function
    public function cm_movies(Request $request, MovieService $movieService)
    {
        // Get Movie Data
        [$movies, $total] = $movieService->getData($request, 30);
        return view('backend.movies.data', compact('movies'))->with('i', (request()->input('page', 1) - 1) * 30);
    }

    // Movies Create Function
    public function create()
    {
        return view('backend.movies.create');
    }

    // Movie Store Function
    public function store(Request $request, MovieService $movieService)
    {
        // Store Movie Data
        $result = $movieService->storeData($request);
        return response()->json(['status' => 1, 'message' => 'success', 'result' => $result,]);
    }

    // Movies Show Function
    public function show(Movie $movie)
    {
        //
    }

    // Movies Edit Function
    public function edit($id, MovieService $movieService)
    {
        // Get Edit Movie Data
        [$movie, $download_links, $page] = $movieService->getEditMovie($id);
        return view('backend.movies.edit', compact('movie', 'download_links', 'page'));
    }

    // Movies Update Function
    public function update(Request $request, Movie $movie, MovieService $movieService)
    {
        $url = '/admin/movies?page=' . $request->page;
        $isSuccess = true;
        try {
            DB::beginTransaction();
            // Update DL URL Movie 
            $movieService->updateMovieDLURL($movie, $request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $isSuccess = false;
        }

        // Success
        if ($isSuccess) {
            return redirect($url)->with('success', 'Updated Success');
        }

        // Failed
        if (!$isSuccess) {
            return redirect($url)->with('error', 'Something Went Wrong!');
        }
    }

    // Movie Delete Function
    public function destroy(Movie $movie)
    {
        //
    }
}