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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
/**  
 * Buyer
*/
Route::resource('buyers','Buyer\BuyerControler',['only'=>'show']);
/** 
 * Categories
*/
Route::resource('categories','Category\CategoryControler',['exept'=>['create','edit']]);

/**  
 * Products
*/
Route::resource('products','Product\ProductControler',['only'=>['index','show']]);

/**
 * Transactions
 */
Route::resource('transactions','Transaction\TransactionControler',['only'=>['index','show']]);

/**
 * Sellers
 */
Route::resource('sellers','Seller\SellerControler',['only'=>['index','show']]);

/**
 * Users
 */
Route::resource('users','User\UserControler',['except'=>['create','edit']]);
