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
        Route::get('forgot_password', 'Admin\Auth\ForgotPasswordController@getFormResetPassword')->name('forgot_password');
        Route::post('forgot_password', 'Admin\Auth\ForgotPasswordController@sendCodeResetPassword')->name('forgot_password');
        Route::get('reset_password', 'Admin\Auth\ForgotPasswordController@resetPassword')->name('reset_password');
    });
    Route::group(['middleware' => ['auth']], function () {
        Route::get('logout', 'Admin\Auth\LoginController@logout')->name('logout');
        Route::get('change_password', 'Admin\Auth\ChangePasswordController@getChangePassword')->name('change_password');
        Route::post('change_password', 'Admin\Auth\ChangePasswordController@postChangePassword')->name('change_password');
        Route::get('menu', 'Admin\DashboardController@index')->name('menu');
    });
});

