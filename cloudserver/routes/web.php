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
Route::get('/register', 'PagesController@register');
Route::get('/newRasp', 'NewRaspController@showNewRaspForm')->name('newRasp');

Auth::routes();

Route::post('/newRasp', 'NewRaspController@registerNewRasp');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@getDevicesWithSeveralRaspberries')->name('getDevicesWithSeveralRaspberries');
