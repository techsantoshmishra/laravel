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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
    die('test');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/login1', 'Login@login');

Route::group([
    'prefix' => 'blogs',
], function () {
    Route::get('/', 'BlogsController@index')
         ->name('blogs.blog.index');
    Route::get('/create','BlogsController@create')
         ->name('blogs.blog.create');
    Route::get('/show/{blog}','BlogsController@show')
         ->name('blogs.blog.show')->where('id', '[0-9]+');
    Route::get('/{blog}/edit','BlogsController@edit')
         ->name('blogs.blog.edit')->where('id', '[0-9]+');
    Route::post('/', 'BlogsController@store')
         ->name('blogs.blog.store');
    Route::put('blog/{blog}', 'BlogsController@update')
         ->name('blogs.blog.update')->where('id', '[0-9]+');
    Route::delete('/blog/{blog}','BlogsController@destroy')
         ->name('blogs.blog.destroy')->where('id', '[0-9]+');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

