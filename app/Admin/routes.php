<?php

Route::get('', [
	'as' => 'admin.home',
	function ()
	{
		$content = 'Define your dashboard here.';
		return Admin::view($content, 'Dashboard');
	}
]);

Route::post('eloquent_users', '\App\Http\Controllers\AuthController@adminUserCreate');
Route::post('eloquent_users/{id}', '\App\Http\Controllers\AuthController@adminUserUpdate');
Route::post('roles', '\App\Http\Controllers\AuthController@adminRoleCreate');
Route::post('roles/{id}', '\App\Http\Controllers\AuthController@adminRoleUpdate');

