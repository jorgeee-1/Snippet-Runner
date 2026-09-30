<?php

use App\Http\Controllers\RunController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('playground');
});

Route::post('/run', [RunController::class, 'run']);
