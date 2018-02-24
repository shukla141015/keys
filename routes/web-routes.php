<?php

Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);
// Route::view('/', 'home');


Route::get('login',   ['uses' => 'Auth\LoginController@showLoginForm', 'as' => 'login']);
Route::post('login',  ['uses' => 'Auth\LoginController@login']);
Route::post('logout', ['uses' => 'Auth\LoginController@logout',        'as' => 'logout']);

Route::get('register',  ['uses' => 'Auth\RegisterController@showRegistrationForm', 'as' => 'register']);
Route::post('register', ['uses' => 'Auth\RegisterController@register']);

Route::get('password/reset',         ['uses' => 'Auth\ForgotPasswordController@showLinkRequestForm', 'as' => 'password.request']);
Route::post('password/email',        ['uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail',  'as' => 'password.email']);
Route::get('password/reset/{token}', ['uses' => 'Auth\ResetPasswordController@showResetForm',        'as' => 'password.reset']);
Route::post('password/reset',        ['uses' => 'Auth\ResetPasswordController@reset']);
