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
Route::prefix('system')->group(function () {
   // dd(1);

    //Route::post('login', 'LoginController@login');
    //Route::post('register', 'LoginController@register');

   // Route::group(['middleware' => 'auth:api'], function () {

        Route::namespace('Manage')->group(function () {
            Route::post('user', 'ManageController@userList')->name('user');

            Route::post('role', 'RoleController@roleList')->name('role');
            Route::post('role/create', 'RoleController@roleCreate')->name('roleCreate');
            Route::post('role/update', 'RoleController@roleUpdate');
            Route::post('role/info', 'RoleController@roleInfo')->name('roleInfo');
            Route::delete('role/delete', 'RoleController@roleDelete')->name('roleDelete');


            Route::post('permission/create', 'PermissionController@permissionCreate');
        });

        //Route::post('getdetails', 'LoginController@getDetails');
    //});







});
