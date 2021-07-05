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
    return view('student.index');
});


Route::post('/student/store','StudentController@store')->name('student.store');
Route::get('/student/show','StudentController@show')->name('student.show');
Route::get('/student/edit/{id}','StudentController@edit')->name('student.edit');
Route::post('/student/update/{id}','StudentController@update')->name('student.update');