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

    Route::post('login', 'LoginController@login');

    Route::group(['middleware' => 'auth:api'], function () {

        //权限管理
        Route::namespace('Manage')->group(function () {
            Route::post('index', 'IndexController@index')->name('index');

            Route::post('user', 'ManageController@userList')->name('user');
            Route::post('user/create', 'ManageController@userCreate')->name('userCreate');
            Route::post('user/delete', 'ManageController@userDelete')->name('userDelete');
            Route::post('user/info', 'ManageController@userInfo')->name('userInfo');
            Route::post('user/update', 'ManageController@userUpdate')->name('userUpdate');
            Route::post('user/passwordReset', 'ManageController@passwordReset')->name('passwordReset');

            Route::post('role', 'RoleController@roleList')->name('role');
            Route::post('role/create', 'RoleController@roleCreate')->name('roleCreate');
            Route::post('role/update', 'RoleController@roleUpdate');
            Route::post('role/info', 'RoleController@roleInfo')->name('roleInfo');
            Route::delete('role/delete', 'RoleController@roleDelete')->name('roleDelete');
            Route::post('role/assignPermission', 'RoleController@assignPermission')->name('assignPermission');
            Route::post('role/permissionList', 'RoleController@permissionList')->name('permissionList');

            Route::post('permission/create', 'PermissionController@permissionCreate');
        });

        //用户管理
        Route::namespace('Client')->group(function () {

            Route::post('shopeeker', 'ShopController@shopeekerList')->name('shopeeker');
            Route::post('shopeeker/info', 'ShopController@shopeekerInfo')->name('shopeekerInfo');
            Route::post('shopeeker/passwordReset', 'ShopController@passwordReset')->name('shopPasswordReset');
            Route::post('shopeeker/statusChange', 'ShopController@statusChange')->name('statusChange');


            Route::post('buyer', 'BuyerController@buyerList')->name('buyer');

        });

    });







});
