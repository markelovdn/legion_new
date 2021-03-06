<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\DB;



Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/users', 'UserController@showUsersList')->name('users');
    Route::get('/security/{id}', 'UserController@showUserSecurForm');
    Route::get('/general/{id}', 'UserController@showUserGeneralForm');
    Route::get('/media/{id}', 'UserController@showUserMediaForm');
    Route::get('/status/{id}', 'UserController@showUserStatusForm');
    Route::get('/profile/{id}', 'UserController@showUserProfile');
    Route::match(['get', 'post'], '/createuser', 'UserController@showCreateUserForm')->name('createuser');

    Route::post('/addNewUser', 'UserController@addNewUser');
    Route::post('/editUserSecurInfo', 'UserController@editUserSecurInfo');
    Route::post('/editUserGeneralInfo', 'UserController@editUserGeneralInfo')->name('editUserGeneralInfo');
    Route::post('/editUserStatusInfo', 'UserController@editUserStatusInfo')->name('editUserStatusInfo');
    Route::post('/editUserMediaInfo', 'UserController@editUserMediaInfo');
    Route::get('/delUser/{id}', 'UserController@delUser');
});

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');








