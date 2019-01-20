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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* Admin Authentication Route */
Route::get('/AdminHome', 'AdminHomeController@index')->name('admin.home');
Route::post('/AdminLogin', 'Admin\AdminLoginController@login');
Route::get('/AdminLogin', 'Admin\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/AdminLogout', 'Admin\AdminLoginController@logout')->name('admin.logout');
Route::post('/AdminPassword/email', 'Admin\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('/AdminPassword/reset', 'Admin\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('/AdminPassword/reset', 'Admin\AdminResetPasswordController@reset')->name('admin.password.update');
Route::get('/AdminPassword/reset/{token}', 'Admin\AdminResetPasswordController@showResetForm')->name('admin.password.reset');


