<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APIController extends Controller
{
    //

    public static function response($code, $data)
    {
        if ($code == '1') {
            $response = [
                'status' => 1,
                'message' => 'Success',
                'data' => $data
            ];
        }

        if ($code == '0') {
            $response = [
                'status' => 0,
                'message' => 'Error',
                'data' => null
            ];
        }

        return $response;
    }
}