<?php

namespace App\Services;

use App\Models\Movie;
use stdClass;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use App\Http\Controllers\SnifferController;
use Illuminate\Support\Facades\DB;
use App\Models\DownloadLink;

class MovieService
{
  // Get Movie Data
  public function getData($request, $paginate)
  {
    $movies = Movie::orderBy('created_at', 'desc');

    // Filter Movies
    $filteredMovies = $this->movieFilter($movies, $request);

    $total = $filteredMovies->count();
    $movies = $filteredMovies->paginate($paginate);

    return [$movies, $total];
  }

  // Store Movie Data
  public function storeData($request)
  {
    // Clean URL
    $urlArray =  $this->cleanURL($request->urls);
    $result = [];

    foreach ($urlArray as $url) {
      // obj 
      $obj = new stdClass;
      $obj->title = '';
      $obj->imdb_id = '';
      $obj->result = '';

      // Load the HTML content from the webpage
      $dom = new \DOMDocument();
      $dom->loadHTMLFile($url, LIBXML_NOERROR);

      $original_title = SnifferController::sinff_title($dom);
      $pattern = '/\s?\(\s?\d{4}\s?\)/';
      $replacement = '';
      $title = preg_replace($pattern, $replacement, $original_title);
      $imdb_id = SnifferController::sniff_imdb($dom);
      $poster = SnifferController::sniff_poster($dom);
      $description = SnifferController::sniff_description($dom);
      $download_links = SnifferController::sniff_urls($dom);
      $year = '';
      // get year
      $pattern = '/\(\s*(.*?)\s*\)/';
      $replacement = '$1';
      $matches = [];
      if (preg_match($pattern, $original_title, $matches)) {
        $year = $matches[1];
      }

      try {
        DB::beginTransaction();
        // Download Poster Image File
        $fileName = $imdb_id . '_' . $year . '.jpg';
        $client = new Client();
        $response = $client->get($poster);
        Storage::disk('public')->put('posters/' . $fileName, $response->getBody());

        // Perform your database operations here
        $movie = Movie::create([
          'title' => $title,
          'imdb_id' =>  $imdb_id,
          'poster' => $fileName,
          'cm_url' => $url,
          'year' =>  $year,
          'description' => $description,
        ]);

        foreach ($download_links as $link) {
          $service = '';
          // Megaup
          if (str_starts_with($link, 'https://megaup.net')) {
            $service = 'Mega Up';
          }

          // Meganz
          if (str_starts_with($link, 'https://mega.nz')) {
            $service = 'Mega NZ';
          }
          // Yoteshin
          if (str_starts_with($link, 'https://yoteshinportal.cc')) {
            $service = 'Yoteshin Portal';
          }

          DownloadLink::create([
            'movie_id' => $movie->id,
            'url' => $link,
            'service' => $service,
          ]);
        }

        DB::commit();

        $obj->title = $title;
        $obj->imdb_id = $imdb_id;
        $obj->result = 'Success';
        array_push($result, $obj);
      } catch (\Exception $e) {
        DB::rollBack();

        $obj->title = $title;
        $obj->imdb_id = $imdb_id;
        $obj->result = 'Failed';
        array_push($result, $obj);
      }
    }

    return $result;
  }

  // Clean URL
  public function cleanURL($url)
  {
    $urlsArray = explode("\n", $url);
    $urlsArray = array_map(function ($url) {
      return str_replace("\r", "", $url);
    }, $urlsArray);

    return $urlsArray;
  }

  // Movie Filter 
  public function movieFilter($movies, $request)
  {

    // Keyword Search
    if ($request->keyword != '') {
      $movies = $movies->where(function ($query) use ($request) {
        $query->where('title', 'LIKE', '%' . $request->keyword . '%')
          ->orWhere('imdb_id', 'LIKE', '%' . $request->keyword . '%')
          ->orWhere('cm_url', $request->keyword)
          ->orWhere('year', $request->keyword);
      });
    }

    // Year Search
    if ($request->year != '') {
      $movies = $movies->where('year', $request->year);
    }

    // Status Search
    if ($request->status != '') {
      $movies = $movies->where('verified', $request->status);
    }

    return $movies;
  }

  // Get Edit Movie Data
  public function getEditMovie($id)
  {
    $idArray = explode('-', $id);
    $movie_id = $idArray[0];
    $page = $idArray[1];
    $movie = Movie::find($movie_id);
    $download_links = DownloadLink::where('movie_id', $movie_id)->get();

    return [$movie, $download_links, $page];
  }

  // 
  public function updateMovieDLURL($movie, $request)
  {
    $movie->update([
      'title' => $request->title,
      'imdb_id' =>  $request->imdb_id,
      'poster' => $request->poster,
      'cm_url' => $request->cm_url,
      'year' =>  $request->year,
      'description' => $request->description,
      'verified' => 1,
    ]);

    foreach ($request->all() as $key => $value) {
      if (str_starts_with($key, 'link-')) {

        $paramArray = (explode("-", $key));
        $download_link_id = $paramArray[1];
        DownloadLink::find($download_link_id)->update([
          'url' => $value
        ]);
      }
    }

    return true;
  }
}