<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetMovieInfoRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\API\APIController;
use stdClass;
use App\Models\Movie;

class SniferController extends Controller
{
    //

    public function getMovieInfo(GetMovieInfoRequest $request)
    {
        $urls = $request->url;

        $index = 0;
        $data = [];

        // loop all request url
        foreach ($urls as $url) {
            $index++;
            $movie =  Movie::where('cm_url', $url)->first();

            $obj = new stdClass;
            $obj->no =   $index;
            $obj->title = '';
            $obj->imdb_id = '';
            $obj->cm_url = $url;
            $obj->description = '';

            if (!is_null($movie)) {
                $obj->title = $movie->title;
                $obj->imdb_id = $movie->imdb_id;
                $obj->description = $movie->description;
            }

            array_push($data, $obj);
        }

        return response()->json(APIController::response(1, $data));
    }
}