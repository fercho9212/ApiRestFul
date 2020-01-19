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

/*  Route::get('/', function () {
    return view('welcome');
});
  */
  $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
  $this->post('login', 'Auth\LoginController@login');
  $this->post('logout', 'Auth\LoginController@logout')->name('logout');



  // Password Reset Routes...
  if ($options['reset'] ?? true) {
      $this->resetPassword();
  }

  // Email Verification Routes...
  if ($options['verify'] ?? false) {
      $this->emailVerification();
  }

Route::get('/home/my-tokens', 'HomeController@getTokens')
  ->name('personal-tokens');
Route::get('/home/my-clients', 'HomeController@getClients')
  ->name('personal-clients');
Route::get('/home/authorized-clients', 'HomeController@getAuthorizedClients')
  ->name('authorized-clients');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function(){
  return view('welcome');
});
