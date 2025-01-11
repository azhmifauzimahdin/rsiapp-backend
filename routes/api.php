<?php

use App\Http\Controllers\Api\IpController;
use App\Http\Controllers\Api\PatientController;
use Illuminate\Support\Facades\Route;

Route::middleware('cek-api')->group(function () {
    Route::prefix('patients')->name('patients.')->controller(PatientController::class)->group(function () {
        Route::post('/', 'store')->name('store');
        Route::middleware('cek-ip')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/finished/{patien_id}', 'statusUpdate')->name('finished');
            Route::get('/today', 'today')->name('today');
            Route::get('/pending', 'pending')->name('pending');
        });
    });

    Route::name('patients.')->controller(IpController::class)->group(function () {
        Route::post("/ip", "store")->name("store");
        Route::get("/ip-check", 'ipCheck')->name("ipCheck");
        Route::middleware('cek-ip')->group(function () {
            Route::get("/authorization", "authorization")->name("authorization");
        });
    });
});
