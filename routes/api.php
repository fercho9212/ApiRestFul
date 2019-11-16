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

Route::resource('buyers','Buyer\BuyerControler',['only'=>['index','show']]);
Route::resource('buyers.transactions','Buyer\BuyerTransactionController',['only'=>['index']]);
Route::resource('buyers.products','Buyer\BuyerProductController',['only'=>['index']]);
Route::resource('buyers.sellers', 'Buyer\BuyerSellerController',['only'=>['index']]);
Route::resource('buyers.categories', 'Buyer\BuyerCategoryController',['only'=>['index']]);
/**
 * Categories
*/
Route::resource('categories','Category\CategoryController',['exept'=>['create','edit']]);

/**  
 * Products
*/
Route::resource('products','Product\ProductController',['only'=>['index','show']]);

/**
 * Transactions
 */
Route::resource('transactions','Transaction\TransactionController',['only'=>['index','show']]);
Route::resource('transactions.categories','Transaction\TransactionCategoryController',['only'=>['index']]);
Route::resource('transactions.sellers','Transaction\TransactionSellerController',['only'=>['index']]);

/**
 * Sellers
 */
Route::resource('sellers','Seller\SellerControler',['only'=>['index','show']]);

/**
 * Users
 */
Route::resource('users','User\UserControler',['except'=>['create','edit']]);
