<?php

use App\Http\Controllers\Web\AuthenticationController;
use App\Http\Controllers\Web\LayoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(LayoutController::class)->group(function () {
    Route::get('/login', 'loginView')->name('login');
});

Route::controller(AuthenticationController::class)->group(function () {
    Route::post('/login', 'doLogin');
    Route::get('/logout', 'doLogout');
});

Route::middleware('auth', 'isadmin')->group(function () {
    Route::controller(LayoutController::class)->group(function () {
        Route::get('/dashboard', 'dashboardView');
        Route::get('/users', 'usersView');
        Route::get('/tasks', 'tasksView');
        Route::get('/tasks/{id}', 'editTaskView');

        Route::prefix('/master-data')->group(function () {
            Route::get('/states', 'statesView');
        });
    });
});
