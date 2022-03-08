<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::patch('update', 'AuthController@update');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::delete('destroy', 'AuthController@destroy');

    Route::apiResource('project', 'projectController');
    Route::apiResource('task', 'taskController');
    Route::patch('task/waiting/{id}', 'taskController@waiting');
    Route::patch('task/completed/{id}', 'taskController@completed');
    Route::patch('task/rejected/{id}', 'taskController@rejected');
    Route::patch('task/inprogress/{id}', 'taskController@inprogress');
    Route::get('projects_task_count', 'taskController@projects_task_count');
});

Route::get('isauth', function () {
    if (Auth::check()) {
        // The user is logged in...
        return response()->json([true]);
    }
    return response()->json([false]);
});
