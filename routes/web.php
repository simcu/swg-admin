<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', 'AuthController@login');
Route::post('/login', 'AuthController@doLogin');
Route::get('/captcha/{tmp}', 'AuthController@captcha');
Route::get('/logout', 'AuthController@logout');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'AuthController@index');
    Route::get('/password', 'AuthController@password');
    Route::post('/password', 'AuthController@changepass');
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'permission'], function () {
        Route::get('/', 'SystemController@eyes');
        Route::group(['prefix' => 'system'], function () {
            Route::group(['prefix' => 'user'], function () {
                Route::get('/', 'SystemController@users');
                Route::post('add', 'SystemController@addUser');
                Route::get('del', 'SystemController@delUser');
            });
            Route::get('/sync', 'SystemController@sync');
            Route::get('/', 'SystemController@eyes');
            Route::post('/fast-add/tcp', 'SystemController@fastAddTcp');
            Route::post('/fast-add/gate', 'SystemController@fastAddGate');
            Route::post('/fast-add/http', 'SystemController@fastAddHttp');
            Route::post('/fast-add/https', 'SystemController@fastAddHttps');
        });
        Route::group(['prefix' => 'gate'], function () {
            Route::group(['prefix' => 'role'], function () {
                Route::get('/', 'GateController@roles');
                Route::post('add', 'GateController@addRole');
                Route::get('del', 'GateController@delRole');
                Route::get('detail', 'GateController@detailRole');
                Route::get('del/site', 'GateController@detailRoleDelHost');
                Route::get('del/user', 'GateController@detailRoleDelUser');
                Route::post('add/site', 'GateController@detailRoleAddHost');
                Route::post('add/user', 'GateController@detailRoleAddUser');
            });
            Route::group(['prefix' => 'site'], function () {
                Route::get('/', 'GateController@sites');
                Route::post('add', 'GateController@addSite');
                Route::get('del', 'GateController@delSite');
            });
            Route::group(['prefix' => 'config'], function () {
                Route::get('/', 'GateController@config');
                Route::post('/', 'GateController@saveConfig');
            });
        });
        Route::group(['prefix' => 'upstream'], function () {
            Route::get('/', 'UpstreamController@all');
            Route::get('detail', 'UpstreamController@detail');
            Route::post('add/host', 'UpstreamController@addHost');
            Route::get('del/host', 'UpstreamController@delHost');
            Route::post('add', 'UpstreamController@add');
            Route::get('del', 'UpstreamController@del');
        });

        Route::group(['prefix' => 'web'], function () {
            Route::get('/', 'WebController@all');
            Route::get('ssl', 'WebController@ssl');
            Route::post('add/ssl', 'WebController@addSsl');
            Route::get('del/ssl', 'WebController@delSsl');
            Route::post('add', 'WebController@add');
            Route::get('del', 'WebController@del');
        });

        Route::group(['prefix' => 'tcp'], function () {
            Route::get('front', 'TcpController@fronts');
            Route::get('backend', 'TcpController@backends');
            Route::post('add/backend', 'TcpController@addBackend');
            Route::get('del/backend', 'TcpController@delBackend');
            Route::post('add', 'TcpController@add');
            Route::get('del', 'TcpController@del');
            Route::get('backend/detail', 'TcpController@backendDetail');
            Route::post('backend/add/detail', 'TcpController@addBackendDetail');
            Route::get('backend/del/detail', 'TcpController@delBackendDetail');
        });


    });
});
