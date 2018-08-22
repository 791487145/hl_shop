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

            Route::post('user', 'ManageController@userList')->name('user')->middleware('can:user');
            Route::post('user/create', 'ManageController@userCreate')->name('userCreate')->middleware('can:userCreate');
            Route::post('user/delete', 'ManageController@userDelete')->name('userDelete')->middleware('can:userDelete');
            Route::post('user/info', 'ManageController@userInfo')->name('userInfo')->middleware('can:userInfo');
            Route::post('user/update', 'ManageController@userUpdate')->name('userUpdate')->middleware('can:userUpdate');
            Route::post('user/passwordReset', 'ManageController@passwordReset')->name('passwordReset')->middleware('can:passwordReset');

            Route::post('role', 'RoleController@roleList')->name('role')->middleware('can:role');
            Route::post('role/create', 'RoleController@roleCreate')->name('roleCreate')->middleware('can:roleCreate');
            Route::post('role/update', 'RoleController@roleUpdate')->middleware('can:roleUpdate');
            Route::post('role/info', 'RoleController@roleInfo')->name('roleInfo')->middleware('can:roleInfo');
            Route::delete('role/delete', 'RoleController@roleDelete')->name('roleDelete')->middleware('can:roleDelete');
            Route::post('role/assignPermission', 'RoleController@assignPermission')->name('assignPermission')->middleware('can:assignPermission');
            Route::post('role/permissionList', 'RoleController@permissionList')->name('permissionList')->middleware('can:permissionList');

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
