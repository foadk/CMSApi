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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')
    ->get('permissions/list', 'PermissionController@getPermissions')
    ->name('public.permissions.list');

Route::middleware(['auth:api', 'acl'])->group(function () {

    Route::post('users/datatable', 'UserController@datatable')->name('admin.users.datatable');
    Route::post('users', 'UserController@store')->name('admin.users.store');
    Route::get('users/{user}/edit', 'UserController@edit')->name('admin.users.edit');
    Route::put('users/{user}', 'UserController@update')->name('admin.users.update');
    Route::delete('users/{user}', 'UserController@delete')->name('admin.users.delete');

    Route::post('news/datatable', 'NewsController@datatable')->name('admin.news.datatable');
    Route::get('news/create', 'NewsController@create')->name('admin.news.create');
    Route::post('news', 'NewsController@store')->name('admin.news.store');
    Route::get('news/{news}/edit', 'NewsController@edit')->name('admin.news.edit');
    Route::put('news/{news}', 'NewsController@update')->name('admin.news.update');
    Route::delete('news/{news}', 'NewsController@delete')->name('admin.news.delete');

    Route::post('permissions/datatable', 'PermissionController@datatable')->name('admin.permissions.datatable');
    Route::post('permissions', 'PermissionController@store')->name('admin.permissions.store');
    Route::get('permissions/{permission}/edit', 'PermissionController@edit')->name('admin.permissions.edit');
    Route::put('permissions/{permission}', 'PermissionController@update')->name('admin.permissions.update');
    Route::delete('permissions/{permission}', 'PermissionController@delete')->name('admin.permissions.delete');
    Route::get('permissions/sync', 'PermissionController@sync')->name('admin.permissions.sync');

    Route::post('roles/datatable', 'RoleController@datatable')->name('admin.roles.datatable');
    Route::get('roles/create', 'RoleController@create')->name('admin.roles.create');
    Route::post('roles', 'RoleController@store')->name('admin.roles.store');
    Route::get('roles/{role}/edit', 'RoleController@edit')->name('admin.roles.edit');
    Route::put('roles/{role}', 'RoleController@update')->name('admin.roles.update');
    Route::delete('roles/{role}', 'RoleController@delete')->name('admin.roles.delete');

    Route::post('admins/datatable', 'AdminsController@datatable')->name('admin.admins.datatable');
    Route::get('admins/create', 'AdminsController@create')->name('admin.admins.create');
    Route::post('admins', 'AdminsController@store')->name('admin.admins.store');
    Route::get('admins/{user}/edit', 'AdminsController@edit')->name('admin.admins.edit');
    Route::put('admins/{user}', 'AdminsController@update')->name('admin.admins.update');
    Route::delete('admins/{user}', 'AdminsController@delete')->name('admin.admins.delete');
});