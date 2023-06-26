<?php

use App\Http\Controllers\MovieController;


Route::resource('/movies', MovieController::class);
Route::get('/cm_movies', [MovieController::class, 'cm_movies']);
Route::get('/test', [MovieController::class, 'test']);