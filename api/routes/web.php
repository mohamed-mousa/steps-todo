<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes jwt-auth secret [98weUUYgj2XCa73itPe0OnK7gMyDnu9a03UsCgD0BvmYyT6AWlsdE3pcZ7LWXDJw] set successfully.
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
