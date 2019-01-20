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
Route::get('/admin', 'AdminHomeController@index')->name('admin.home');
Route::post('/admin/login', 'Admin\AdminLoginController@login');
Route::get('/admin/login', 'Admin\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/logout', 'Admin\AdminLoginController@logout')->name('admin.logout');
Route::post('/admin/password/email', 'Admin\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('/admin/password/reset', 'Admin\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('/admin/password/reset', 'Admin\AdminResetPasswordController@reset')->name('admin.password.update');
Route::get('/admin/password/reset/{token}', 'Admin\AdminResetPasswordController@showResetForm')->name('admin.password.reset');


