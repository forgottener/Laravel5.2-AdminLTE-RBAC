<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    //TODO:前台功能路由
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
//Route::group(['middleware' => 'web'], function () {
//    Route::auth();
//
//    Route::get('/home', 'HomeController@index');
//});

Route::group(['middleware' => ['web'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::auth();
});

Route::group(['middleware' => ['auth.admin'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    //后台首页
    Route::get('index', ['as' => 'admin.index', 'uses' => 'IndexController@index']);

    //权限管理(菜单)路由
    Route::get('permission/{fid?}', ['as' => 'admin.permission.index', 'uses' => 'PermissionController@index']);
    Route::post('permission/index', ['as' => 'admin.permission.index', 'uses' => 'PermissionController@index']); //查询
    Route::get('permission/{fid}/create', ['as' => 'admin.permission.create', 'uses' => 'PermissionController@create']);
    Route::resource('permission', 'PermissionController');
    Route::put('permission/update', ['as' => 'admin.permission.edit', 'uses' => 'PermissionController@update']); //修改
    Route::post('permission/store', ['as' => 'admin.permission.create', 'uses' => 'PermissionController@store']); //添加

    //角色管理路由
    Route::get('role/index', ['as' => 'admin.role.index', 'uses' => 'RoleController@index']);
    Route::post('role/index', ['as' => 'admin.role.index', 'uses' => 'RoleController@index']);
    Route::resource('role', 'RoleController');
    Route::put('role/update', ['as' => 'admin.role.edit', 'uses' => 'RoleController@update']); //修改
    Route::post('role/store', ['as' => 'admin.role.create', 'uses' => 'RoleController@store']); //添加

    //用户管理路由
    Route::get('user/index', ['as' => 'admin.user.index', 'uses' => 'UserController@index']);  //用户管理
    Route::post('user/index', ['as' => 'admin.user.index', 'uses' => 'UserController@index']);
    Route::resource('user', 'UserController');
    Route::put('user/update', ['as' => 'admin.user.edit', 'uses' => 'UserController@update']); //修改
    Route::post('user/store', ['as' => 'admin.user.create', 'uses' => 'UserController@store']); //添加

});
