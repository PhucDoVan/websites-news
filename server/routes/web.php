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

Route::get('/', function () {
    return view('welcome');
});
//Admin route
Route::prefix('admin')->name('admin.')->group(function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', 'Admin\Auth\LoginController@getLogin')->name('login');
        Route::post('login', 'Admin\Auth\LoginController@postLogin')->name('login');
    });
    Route::group(['middleware' => ['auth']], function () {
        Route::get('logout', 'Admin\Auth\LoginController@logout')->name('logout');
        Route::get('change_password', 'Admin\Auth\ChangePasswordController@getChangePassword')->name('change_password');
        Route::post('change_password', 'Admin\Auth\ChangePasswordController@postChangePassword')->name('change_password');
        Route::get('menu', 'Admin\DashboardController@index')->name('menu');
    });
});

