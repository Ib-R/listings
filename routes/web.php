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

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/frontend', 'ItemsController@api');

Route::resource('posts', 'PostsController');
Route::resource('api', 'ItemsController');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('front');

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', 'customAdmin'],
    'namespace' => 'Admin'
], function() {
    Route::get('login', 'Auth\LoginController@showLoginForm');
    Route::post('login', 'Auth\LoginController@login');

    // Registration Routes...
    Route::get('register', '\Backpack\Base\app\Http\Controllers\Auth\RegisterController@showRegistrationForm');
    Route::post('register', '\Backpack\Base\app\Http\Controllers\Auth\RegisterController@register');
    Route::get('logout', '\Backpack\Base\app\Http\Controllers\Auth\LoginController@logout');
    Route::get('dashboard', '\Backpack\Base\app\Http\Controllers\AdminController@dashboard');
    Route::get('/', '\Backpack\Base\app\Http\Controllers\AdminController@redirect');

    // your CRUD resources and other admin routes here
    CRUD::resource('post', 'PostCrudController');
    CRUD::resource('tag', 'TagCrudController');
});