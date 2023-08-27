<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ContributorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::controller(CollectionController::class)->group(function () {
    Route::get('collections', 'index');
    Route::get('details','details');
    Route::get('collections/remains','remainsToCollect');
    Route::get('collections/less','lessThanTarget');
    Route::post('collection','store');
});


Route::controller(ContributorController::class)->group(function () {
    Route::post('contributor','store');
});
