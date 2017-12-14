<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'TasksController@index');

Route::resource('tasks', 'TasksController');

// CRUD ( resource の省略前 ↑上記の一文で省略できる部分)
// Route::post('tasks', 'TasksController@store')->name('tasks.store');
// Route::put('tasks/{id}', 'TasksController@update')->name('tasks.update');
// Route::delete('tasks/{id}', 'TasksController@destroy')->name('tasks.destroy');

// index: showの補助ページ
// Route::get('tasks', 'TasksController@index')->name('tasks.index');

// create: 新規作成用のフォームページ
// Route::get('tasks/create', 'TasksController@create')->name('tasks.create');

// show: 個別の内容詳細ページ
// Route::get('tasks/{id}', 'TasksController@show')->name('tasks.show');

// edit: 更新用のフォームページ
// Route::get('tasks/{id}/edit', 'TasksController@edit')->name('tasks.edit');

// ユーザ登録
Route::get('signup', 'Auth\AuthController@getRegister')->name('signup.get');
Route::post('signup', 'Auth\AuthController@postRegister')->name('signup.post');

// ログイン認証
Route::get('login', 'Auth\AuthController@getLogin')->name('login.get');
Route::post('login', 'Auth\AuthController@postLogin')->name('login.post');
Route::get('logout', 'Auth\AuthController@getLogout')->name('logout.get');

// ログイン認証の確認
Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
});