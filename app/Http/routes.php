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

Route::get('/','StaticPagesController@home')->name('home');
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('about');

// 用户注册页面 多余的，用户资源路由中已经存在
// Route::get('signup', 'UsersController@create')->name('signup');

// 用户资源路由
Route::resource('users', 'UsersController');

//用户登录、退出
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

// 重置密码
Route::get('password/email', 'Auth\PasswordController@getEmail')->name('password.reset');
Route::post('password/email', 'Auth\PasswordController@postEmail')->name('password.reset');
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset')->name('password.edit');
Route::post('password/reset', 'Auth\PasswordController@postReset')->name('password.update');

// 微博的创建和删除
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);

// 用户关注者列表和粉丝列表
Route::get('/users/{id}/followings', 'UsersController@followings')->name('users.followings');
Route::get('/users/{id}/followers', 'UsersController@followers')->name('users.followers');

//关注与取消关注
Route::post('/users/followers/{id}', 'FollowersController@store')->name('followers.store');
Route::delete('/users/followers/{id}', 'FollowersController@destroy')->name('followers.destroy');