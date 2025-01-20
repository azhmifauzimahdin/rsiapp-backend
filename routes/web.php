<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('storage/images/signature/{image}')->middleware('redirect-image');
