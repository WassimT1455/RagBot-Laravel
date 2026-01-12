<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestApiController;

Route::get('/', function () {
    return view('welcome'); // Contient ton HTML du chat
});

Route::post('/chat', [TestApiController::class, 'ask']);
