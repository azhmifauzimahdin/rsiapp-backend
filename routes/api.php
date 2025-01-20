<?php

use App\Http\Controllers\Api\IpController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\SignatureController;
use Illuminate\Support\Facades\Route;

Route::middleware('check-api')->group(function () {
    Route::prefix('patients')->name('patients.')->controller(PatientController::class)->group(function () {
        Route::post('/', 'store')->name('store');
        Route::middleware('check-ip:0')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/finished/{patien_id}', 'statusUpdate')->name('finished');
            Route::get('/today', 'today')->name('today');
            Route::get('/pending', 'pending')->name('pending');
        });
    });

    Route::name('ip.')->controller(IpController::class)->group(function () {
        Route::post("/ip", "store")->name("store");
        Route::get("/ip-check", 'ipCheck')->name("ipCheck");
        Route::middleware('check-ip:0')->group(function () {
            Route::get("/authorization", "authorization")->name("authorization");
        });
        Route::middleware('check-ip:1')->group(function () {
            Route::get("/authorization1", "authorization")->name("authorization");
        });
        Route::middleware('check-ip:2')->group(function () {
            Route::get("/authorization2", "authorization")->name("authorization");
        });
    });

    Route::middleware('check-ip:2')->prefix('signature')->name('signature.')->controller(SignatureController::class)->group(function () {
        Route::post("/", "store")->name("store");
        Route::delete("/{rm}", "destroy")->name("destroy");
        Route::get("/{rm}", "show")->name("show");
    });
});
