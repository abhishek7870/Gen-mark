<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('states','StateController');
Route::resource('dealers','DealerController');
Route::post('signin','DealerController@signIn');
Route::post('logout','DealerController@logout')->middleware('jwt.auth');
Route::post('display','DealerController@display')->middleware('jwt.auth');