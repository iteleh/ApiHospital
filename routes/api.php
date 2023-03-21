<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;

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
$router->get('/', function () {
    return response()->json('Welcome to Hospital API');
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'App\Http\Controllers\API\RegisterController@register');
    Route::post('login', 'App\Http\Controllers\API\RegisterController@login');
});

Route::apiResource('/appointments', 'App\Http\Controllers\API\AppointmentController');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
