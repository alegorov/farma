<?php

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

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);

Route::resource(
    'notifications',
    'App\Http\Controllers\NotificationController',
    [
        'except' => ['create', 'edit']
    ]
);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::view('/vue', 'vue');
Route::resource('/api/events', 'App\Http\Controllers\API\EventsController');
