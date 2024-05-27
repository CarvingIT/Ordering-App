<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => '/admin'], function(){
	Route::group(['middleware' => 'admin'], function(){
		
	//People/Users
        Route::get('/people', '\App\Http\Controllers\UserController@index')->name('usermanagement');
        Route::get('/user-form/{user_id}', '\App\Http\Controllers\UserController@addEditUser');
        Route::post('/saveuser', '\App\Http\Controllers\UserController@save');
        Route::get('/people/{user_id}','\App\Http\Controllers\UserController@viewUser');
        Route::post('/people/delete', '\App\Http\Controllers\UserController@deleteUser');

	//Sellers
        Route::get('/sellerprofiles', '\App\Http\Controllers\SellerProfileController@index')->name('sellersmanagement');
        Route::get('/seller-profile-form/{seller_id}', '\App\Http\Controllers\SellerProfileController@addEditSellerProfile');
        Route::post('/saveseller', '\App\Http\Controllers\SellerProfileController@save');
        Route::get('/seller/{seller_id}','\App\Http\Controllers\SellerProfileController@viewSeller');
        Route::post('/seller/delete', '\App\Http\Controllers\SellerProfileController@deleteSeller');

	//Taxonomies
        Route::get('/taxonomies', '\App\Http\Controllers\TaxonomyController@index')->name('taxonomies');
        Route::get('/taxonomy-form/{taxonomy_id}/{parent_id?}', '\App\Http\Controllers\TaxonomyController@addEditTaxonomy');
        Route::post('/savetaxonomy', '\App\Http\Controllers\TaxonomyController@save');
        Route::get('/taxonomy/{taxonomy_id}','\App\Http\Controllers\TaxonomyController@viewUser');
        Route::post('/taxonomy/delete', '\App\Http\Controllers\TaxonomyController@deleteUser');

	//Products
        Route::get('/products', '\App\Http\Controllers\ProductController@index')->name('products');
        Route::get('/product-form/{product_id}', '\App\Http\Controllers\ProductController@addEditProduct');
        Route::post('/saveproduct', '\App\Http\Controllers\ProductController@save');
        Route::get('/product/{product_id}','\App\Http\Controllers\ProductController@viewProduct');
        Route::post('/product/delete','\App\Http\Controllers\ProductController@deleteProduct');

	});
});

require __DIR__.'/auth.php';
