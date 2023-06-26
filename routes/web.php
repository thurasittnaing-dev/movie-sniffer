<?php

use Illuminate\Support\Facades\Route;

// Authentication Routes
Auth::routes();

// Home Module (Frontend)
include_once('frontend.php');


// Admin Route Group
Route::group(['prefix' => 'admin'], function () {

    // Page Module
    include_once('page.php');

    // Movie Module
    include_once('movie.php');
});