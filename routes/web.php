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

Route::get('todo/{id}', 'TodoController@index', function(){

})->middleware('auth');
Route::post('todo', 'TodoController@create');
Route::put('todo', 'TodoController@update');
Route::delete('todo', 'TodoController@delete');

Route::post('/home', 'HomeController@create');
Route::delete('/home', 'HomeController@delete');
Route::put('/home', 'HomeController@update');
Route::get('/home', 'HomeController@index');

Auth::routes();
