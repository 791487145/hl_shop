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
Route::prefix('buyer')->group(function () {

    Route::post('login', 'LoginController@login');

    Route::group(['middleware' => 'auth:api'], function () {

        //权限管理
        Route::namespace('Center')->group(function () {
            Route::post('center', 'CenterController@center');
            Route::post('center/passwordReset', 'CenterController@passwordReset');

            Route::post('center/myBillList', 'BillController@myBillList');
            Route::post('center/billInfo', 'BillController@billInfo');
            Route::post('center/billfileSubmit', 'BillController@billfileSubmit');

            Route::post('center/covercharseList', 'CovercharseController@covercharseList');
        });

    });







});

