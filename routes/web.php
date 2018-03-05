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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profiles/{user}','ProfileController@show')->name('profile');
Route::get('/profiles/{user}/notifications','UserNotificationController@index');
Route::delete('/profiles/{user}/notifications/{notification}','UserNotificationController@destroy');

//Route::resource('threads','ThreadController');
Route::get('threads','ThreadController@index');
Route::post('threads','ThreadController@store');
Route::get('threads/create','ThreadController@create');
Route::get('threads/{channel}/{thread}','ThreadController@show');
Route::delete('threads/{channel}/{thread}','ThreadController@destroy');
Route::get('threads/{channel}','ThreadController@index');

Route::get('threads/{channel}/{thread}/replies','ReplyController@index');
Route::post('threads/{channel}/{thread}/replies','ReplyController@store')->name('add_reply');
Route::delete('/replies/{reply}','ReplyController@destroy');
Route::patch('/replies/{reply}','ReplyController@update');

Route::post('/threads/{channel}/{thread}/subscriptions','ThreadSubscriptionController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions','ThreadSubscriptionController@destroy')->middleware('auth');

Route::post('/replies/{reply}/favorites','FavoriteController@store');
Route::delete('/replies/{reply}/favorites','FavoriteController@destroy');

Route::get('/api/users','Api\UsersController@index');
Route::post('/api/users/{user}/avatar','Api\UserAvatarController@store');
