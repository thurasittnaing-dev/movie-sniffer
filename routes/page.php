<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\HomeController;

Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');