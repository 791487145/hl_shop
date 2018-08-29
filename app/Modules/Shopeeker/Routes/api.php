<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('shopeeker')->group(function () {

    Route::post('login', 'LoginController@login');
    Route::post('city', 'UploadController@city');
    Route::post('register', 'LoginController@register');
    Route::post('mobile', 'LoginController@checkMobile');
    Route::post('upload', 'UploadController@upload');
    Route::post('fileDelete', 'UploadController@fileDelete');
    Route::get('download', 'UploadController@download');

    Route::group(['middleware' => 'auth:api'], function () {

        Route::namespace('Center')->group(function () {
            Route::post('center/passwordReset', 'CenterController@passwordReset');
            Route::post('center/contractList', 'CenterController@contractList');
        });

    });




});
