<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Auth
Route::get('/', 'AuthController@loginPage')->name('login');

Route::get('registration', 'AuthController@registrationPage')->name('registration-page');

Route::post('auth', 'AuthController@login')->name('auth');
Route::post('registration', 'AuthController@registration')->name('registration');

//Dashboard
Route::middleware('auth')->group(function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::prefix('chat')->group(function () {
        Route::get('room-create', function () {
            return view('chat.room-create');
        })->name('chat-room-create');

        Route::post('room-store', 'ChatController@roomCreate')->name('chat-room-store');
    });

    Route::get('logout', 'AuthController@logout')->name('logout');
});
