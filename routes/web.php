<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/index');
});

Auth::routes();
Route::get('logout', 'QovexController@logout');

Route::get('pages-login', 'QovexController@index');
Route::get('pages-login-2', 'QovexController@index');
Route::get('pages-register', 'QovexController@index');
Route::get('pages-register-2', 'QovexController@index');
Route::get('pages-recoverpw', 'QovexController@index');
Route::get('pages-recoverpw-2', 'QovexController@index');
Route::get('pages-lock-screen', 'QovexController@index');
Route::get('pages-lock-screen-2', 'QovexController@index');
Route::get('pages-404', 'QovexController@index');
Route::get('pages-500', 'QovexController@index');
Route::get('pages-maintenance', 'QovexController@index');
Route::get('pages-comingsoon', 'QovexController@index');
Route::post('login-status', 'QovexController@checkStatus');


// You can also use auth middleware to prevent unauthenticated users
Route::group(['middleware' => 'auth'], function () {
    //会员中心
    Route::get('index', 'QovexController@index')->name('index');
    //权限管理
    Route::resource('role', 'RoleController')->except(['show']);
    //员工
    Route::resource('user', 'UserController')->except(['show']);
    //部门
    Route::resource('department', 'DepartmentController')->only(['store', 'update', 'destroy', 'show']);
    //团队
    Route::resource('group', 'GroupController')->except(['show']);

//    Route::get('{any}', 'QovexController@index');
});
