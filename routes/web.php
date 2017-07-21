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

Route::group(['middleware' => ['web']], function () {

	Route::get('/', function () {
    return view('welcome');
})->name('home');

	Route::post('/signup', 'UserController@postSignUp')->name('signup');
	Route::get('/dashboard', [

			'uses' => 'PostController@getDashBoard',
			'as' => 'dashboard'
		]);

	Route::post('/signin', 'UserController@postSignIn')->name('signin');

	Route::post('/createpost', 'PostController@postCreatePost')->name('post.create');
	Route::get('/delete-post/{id}', 'PostController@getDeletePost')->name('post.delete');
	Route::get('/logout', 'UserController@getLogout')->name('logout');

	Route::post('/edit', 'PostController@postEditPost')->name('edit');

	Route::get('/account', 'UserController@getAccount')->name('account');

	Route::post('/updateaccount', 'UserController@PostSaveAccount')->name('account.save');

	Route::get('/userimage/{filename}', 'UserController@getUserImage')->name('account.image');

	Route::post('/like', 'PostController@postLikePost')->name('like');

});
