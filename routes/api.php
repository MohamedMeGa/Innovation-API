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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['namespace'=>'API',  'middleware'=>'api'], function(){

    ######################### Start Category Routing #######################
    Route::group(['prefix'=>'category'], function(){
        Route::post('/active','CategoryController@activeCategory');
        Route::post('/stop','CategoryController@stopCategory');
        Route::post('/showActive','CategoryController@showActiveCategory');
        Route::post('/showStop','CategoryController@showStopCategory');
    });
    ######################### End Product Routing ########################














    ######################### Start Product Routing ########################
    Route::group(['prefix'=>'product'], function(){
        Route::post('/add_image','ProdctController@addimage');
        Route::post('/active','ProdctController@activeProduct');
        Route::post('/stop','ProdctController@stopProduct');
        Route::post('/showActive','ProdctController@showActiveProduct');
        Route::post('/showStop','ProdctController@showStopProduct');
        Route::post('/showHigh','ProdctController@showHighPrice');
        Route::post('/showLow','ProdctController@showLowPrice');
        Route::post('/showCategoryNotHaveProduct','ProdctController@CategoryNotHasProducts');
        Route::post('/CategoryHasHighProducts','ProdctController@CategoryHasHighProducts');
        Route::post('/CategoryHasLowProducts','ProdctController@CategoryHasLowProducts');
        Route::post('/CategoryWithProducts','ProdctController@CategoryWithProducts');
        Route::post('/ActiveCategoryWithActiveProducts','ProdctController@ActiveCategoryWithActiveProducts');
    });
    ######################### End Product Routing ########################











    ######################### Start Admin Routing ########################
    Route::group(['prefix'=>'admin', 'namespace'=>'Auth'], function(){
        Route::post('login', 'AdminController@login');

        Route::group(['middleware'=>'CheckAuth:admin-api'], function(){

            Route::post('addEmployee', 'AdminController@addEmployee');
            Route::post('DeleteEmployee', 'AdminController@DeleteEmployee');
            Route::post('deActiveEmployee', 'AdminController@deActiveEmployee');

            Route::post('addClient', 'AdminController@addClient');
            Route::post('DeleteClient', 'AdminController@DeleteClient');
            Route::post('deActiveClint', 'AdminController@deActiveClint');

            Route::post('editCategory', 'AdminController@editCategory');
            Route::post('editProduct', 'AdminController@editProduct');

            Route::post('logout', 'AdminController@logout');
        });
    });
    ######################### End Admin Routing ########################










    ######################### Start Employee Routing ########################
    Route::group(['prefix'=>'employee', 'namespace'=>'Auth'], function(){
        Route::post('login', 'EmployeeController@login');

        Route::group(['middleware'=>'CheckAuth:employee-api'], function(){

            Route::post('editCategory', 'AdminController@editCategory');
            Route::post('editProduct', 'AdminController@editProduct');

            Route::post('logout', 'EmployeeController@logout');
        });
    });
    ######################### End Employee Routing ########################













    ######################### Start Client Routing ########################
    Route::group(['prefix'=>'client', 'namespace'=>'Auth'], function(){
        Route::post('login', 'ClientController@login');

        Route::group(['middleware'=>'CheckAuth:client-api'], function(){

            Route::post('buy', 'ClientController@buy');
            Route::post('addproducttoshoppingcart', 'ClientController@addProductToShoppingCart');
            Route::post('showShoppingCart', 'ClientController@showShoppingCart');
            Route::post('deleteShoppingCart', 'ClientController@deleteShoppingCart');
            Route::post('logout', 'ClientController@logout');
        });
    });
    ######################### End Client Routing ########################


    Route::post('sendMail', 'Auth\ClientController@sendMail');

});
