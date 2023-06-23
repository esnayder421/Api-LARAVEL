<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// añadimos las rutas 
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function($router){
    // Route::post('users', 'App\Http\Controllers\UsersController@store');
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('register','App\Http\Controllers\AuthController@register');
    Route::put('register/update/{id}','App\Http\Controllers\AuthController@update');
    
    
}
);
Route::resource('users', UsersController::class);
Route::resource('project', ProjectsController::class);
Route::resource('task', TasksController::class);


