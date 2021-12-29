<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
    Route::get('init/date/{date}','\App\Http\Controllers\ApiController@init');

    Route::get('crypto/date/{date}','\App\Http\Controllers\ApiController@getCrypto');

    Route::any('/{path}', function() {
        return response()->json([
            'status'   => 'error',
            'message' => 'Route not found'
        ], 404);
    })->where('path', '.*');
});
