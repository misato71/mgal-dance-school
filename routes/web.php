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

// お客様登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// 認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

Route::group(['middleware' => ['auth']], function () {
    
    // 管理者用
    Route::resource('lessons', 'LessonsController');
    Route::resource('studios', 'StudiosController');
    Route::resource('instructors', 'InstructorsController');
    
    // スケジュール
    Route::get('lesson-schedules/search', 'LessonSchedulesController@search')->name('lesson-schedules.search');
    Route::resource('lesson-schedules', 'LessonSchedulesController');
    Route::get('lesson-schedules/{month}/monthly', 'LessonSchedulesController@monthly')->name('lesson-schedules.monthly');
    
    // 予約   
    Route::get('reservations/search', 'ReservationsController@search')->name('reservations.search');
    Route::get('reservations', 'ReservationsController@index')->name('reservations');
    Route::get('reservations/{id}/create', 'ReservationsController@create')->name('reservations.create');
    Route::post('reservations/store', 'ReservationsController@store')->name('reservations.store');
    Route::get('reservations/{id}/show', 'ReservationsController@show')->name('reservations.show');
    Route::put('reservations/update', 'ReservationsController@update')->name('reservations.update');
    
    // 管理者からの予約
    Route::get('reservation-lists/search', 'ReservationListsController@search')->name('reservation-lists.search');
    Route::resource('reservation-lists', 'ReservationListsController');
    
    // お客様情報
    Route::get('users/search', 'UsersController@search')->name('users.search');
    Route::resource('users', 'UsersController');
    
    //パスワード変更
    Route::get('/password/change','ChangePasswordController@edit')->name('password.edit');
    Route::put('/password/change','ChangePasswordController@update')->name('password.change');
    
});

