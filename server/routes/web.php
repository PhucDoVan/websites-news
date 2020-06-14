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
    Route::get('register', 'Admin\Auth\RegisterController@getRegister')->name('register');
    Route::get('login', 'Admin\Auth\LoginController@getLogin')->name('login');
//    Route::post('login', 'Admin\Auth\LoginController@postLogin');
    Route::get('dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::group(['middleware' => ['checkLoginUser', 'preventBackButton']], function () {

        Route::get('logout', 'Admin\Auth\LoginController@getLogout');

        Route::get('shop', 'Admin\ShopController@index')->name('shop');
        Route::get('top', 'Admin\TopController@getListSlider')->name('top');
        Route::get('site', 'Admin\SiteController@index')->name('site');
        Route::get('event', 'Admin\EventController@list')->name('event');
        Route::get('news', 'Admin\NewsController@list')->name('news');
        Route::get('staff', 'Admin\StaffController@list')->name('staff');
        Route::get('contact', 'Admin\ContactController@list')->name('contact');

        Route::prefix('event')->name('event.')->group(function () {
            Route::get('list', 'Admin\EventController@list')->name('list');
            Route::get('detail', 'Admin\EventController@detail')->name('detail');
        });
        Route::prefix('news')->name('news.')->group(function () {
            Route::get('list', 'Admin\NewsController@list')->name('list');
            Route::get('detail', 'Admin\NewsController@detail')->name('detail');
        });
        Route::prefix('staff')->name('staff.')->group(function () {
            Route::get('list', 'Admin\StaffController@list')->name('list');
            Route::get('detail', 'Admin\StaffController@detail')->name('detail');
        });
        Route::prefix('top')->name('top.')->group(function () {
            Route::post('destroy', 'Admin\TopController@deleteSliders')->name('destroy');
        });
        Route::prefix('contact')->name('contact.')->group(function () {
            Route::get('list', 'Admin\ContactController@list')->name('list');
            Route::get('detail', 'Admin\ContactController@detail')->name('detail');
        });
    });
});

