<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Journey\HomeController;

Route::get('/', function () {
    dd('https://wn.in.th');
});

Route::get('journey', [HomeController::class, 'index']);
