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

Route::group(["prefix" => "user"], function () {
    Route::get("/{user}", "UserController@index")->name('user-profile');
});

Route::group(["prefix" => "media"], function () {
    Route::post("/upload", "MediaController@upload");
    Route::post("/archive", "MediaController@archive");
    Route::post("/trash", "MediaController@trash");
    Route::post("/restrict", "MediaController@restrict");
    Route::post("/unarchive", "MediaController@unarchive");
    Route::post("/untrash", "MediaController@untrash");
    Route::post("/load", "MediaController@returnUserPosts");
});
