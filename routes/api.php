<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\APIToken;

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

Route::post('/register', 'Auth\RegisterController@create');
Route::get('/validateToken', 'Auth\VerificationController@validateToken');
Route::post('/login', 'Auth\LoginController@authenticated');

Route::middleware('APIToken')->group(function(){
    Route::post('/create-bill', 'BillController@store');
    Route::get('/getBills', 'BillController@index');
    Route::get('/getBill/{id}', 'BillController@getById');
});

