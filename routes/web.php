<?php

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

Route::get('/', 'ToppagesController@index');

//  お客様登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

//  認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('lessons', 'LessonsController');
    Route::resource('studios', 'StudiosController');
    Route::resource('instructors', 'InstructorsController');
    Route::resource('lesson-schedules', 'LessonSchedulesController');
    
    //  予約   
    Route::get('reservations', 'ReservationsController@index')->name('reservations');
    Route::get('reservations/{id}/create', 'ReservationsController@create')->name('reservations.create');
    Route::post('reservations/store', 'ReservationsController@store')->name('reservations.store');
    Route::get('reservations/{id}/show', 'ReservationsController@show')->name('reservations.show');
    Route::put('reservations/update', 'ReservationsController@update')->name('reservations.update');

});

