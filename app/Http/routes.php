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
    return view('welcome');
});


Route::get('register', 'AuthController@register');
Route::post('register', 'AuthController@registerProcess');
Route::get('activate/{id}/{code}', 'AuthController@activate');
Route::get('login', 'AuthController@login');
Route::post('login', 'AuthController@loginProcess');
Route::get('logout', 'AuthController@logout');
//Route::post('login', 'AuthController@test');
Route::get('reset', 'AuthController@resetOrder');
Route::post('reset', 'AuthController@resetOrderProcess');
Route::get('reset/{id}/{code}', 'AuthController@resetComplete');
Route::post('reset/{id}/{code}', 'AuthController@resetCompleteProcess');
Route::get('wait', 'AuthController@wait');

//


/**
 * Route for social auth
 */
Route::get('/socialite/{provider}',
    [
        'as' => 'socialite.auth',
        function ( $provider ) {
            return \Socialite::driver( $provider )->redirect();
        }
    ]
);
Route::get('/socialite/{provider}/callback', 'SocialController@supervisor');
