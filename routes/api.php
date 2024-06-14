<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/register', '\App\Http\Controllers\UserController@register');
Route::post('/user/get-token', '\App\Http\Controllers\UserController@login');
Route::get('/product/{product_id}/loadimage/{photo_id}', '\App\Http\Controllers\ProductController@loadProductImage');

Route::group(['middleware' => 'auth:sanctum'], function(){
        Route::get('/taxonomies', '\App\Http\Controllers\TaxonomyController@index');
        Route::get('/category/{category_id}/products/{offset}/{length}', '\App\Http\Controllers\ProductController@getCategoryProducts');
        Route::get('/products/{offset}/{length}', '\App\Http\Controllers\ProductController@index');
        Route::get('/product/{product_id}','\App\Http\Controllers\ProductController@viewProduct');
        Route::get('/seller/{seller_id}','\App\Http\Controllers\SellerProfileController@viewSeller');
	Route::post('/save_user_seller_request', '\App\Http\Controllers\UserController@saveUserSellerRequest');
});


Route::group(['middleware' => 'auth:sanctum','admin'], function(){

        //People/Users
        Route::get('/people', '\App\Http\Controllers\UserController@index');
        Route::get('/user-form/{user_id}', '\App\Http\Controllers\UserController@addEditUser');
        Route::post('/saveuser', '\App\Http\Controllers\UserController@save');
        Route::get('/people/{user_id}','\App\Http\Controllers\UserController@viewUser');
        Route::post('/people/delete', '\App\Http\Controllers\UserController@deleteUser');

        //Taxonomies
        //Route::get('/taxonomies', '\App\Http\Controllers\TaxonomyController@index');
        Route::get('/taxonomy-form/{taxonomy_id}/{parent_id?}', '\App\Http\Controllers\TaxonomyController@addEditTaxonomy');
        Route::post('/savetaxonomy', '\App\Http\Controllers\TaxonomyController@save');
        Route::get('/taxonomy/{taxonomy_id}','\App\Http\Controllers\TaxonomyController@viewUser');
        Route::post('/category/delete', '\App\Http\Controllers\TaxonomyController@deleteCategory');
	
});

Route::group(['middleware' => 'auth:sanctum','seller','admin'], function(){
        //Sellers
        Route::get('/sellerprofiles/{offset}/{length}', '\App\Http\Controllers\SellerProfileController@index');
        Route::get('/my-sellerprofiles/{offset}/{length}', '\App\Http\Controllers\SellerProfileController@getMyBusinesses');
        Route::get('/seller-profile-form/{seller_id}', '\App\Http\Controllers\SellerProfileController@addEditSellerProfile');
        Route::post('/saveseller', '\App\Http\Controllers\SellerProfileController@save');
        //Route::get('/seller/{seller_id}','\App\Http\Controllers\SellerProfileController@viewSeller');
        Route::post('/seller/delete', '\App\Http\Controllers\SellerProfileController@deleteSeller');

        //Products
        Route::get('/my-products/{offset}/{length}', '\App\Http\Controllers\ProductController@getMyProducts');
        Route::get('/product-form/{product_id}', '\App\Http\Controllers\ProductController@addEditProduct');
        Route::post('/saveproduct', '\App\Http\Controllers\ProductController@save');
        Route::post('/product/delete','\App\Http\Controllers\ProductController@deleteProduct');
        Route::post('/product/upload/image','\App\Http\Controllers\ProductController@uploadProductImage');
        Route::post('/product/upload/video_url','\App\Http\Controllers\ProductController@uploadProductVideoURL');
	Route::get('/product/{product_id}/loadvideourl/{video_id}', '\App\Http\Controllers\ProductController@loadProductVideoURL');

});
