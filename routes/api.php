<?php

use App\Http\Controllers\Api\RestAuthController;
use App\Http\Controllers\Api\RestMasterDataController;
use App\Http\Controllers\Api\RestSubTaskController;
use App\Http\Controllers\Api\RestTaskController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('/v1')->group(function () {
    Route::controller(RestAuthController::class)->group(function () {
        Route::post('/login', 'doLogin');
        Route::post('/register', 'doRegister');
        Route::get('/logout', 'doLogout');
    });

    Route::middleware('api')->group(function () {
        Route::controller(RestTaskController::class)->group(function () {
            Route::post('/create-task', 'create');
            Route::put('/update-task', 'update');
            Route::delete('/delete-task', 'delete');
        });
        Route::controller(RestSubTaskController::class)->group(function () {
            Route::post('/create-sub-task', 'create');
            Route::put('/update-sub-task', 'update');
            Route::delete('/delete-sub-task', 'delete');
        });
        Route::controller(RestMasterDataController::class)->group(function () {
            Route::get('/states', 'getStates');
        });
    });
});
