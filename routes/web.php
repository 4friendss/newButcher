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
//main site
Route::get('/', 'IndexController@home');
//File::get(url('997032.txt'));
Route::post('/search', 'IndexController@search');
Route::get('productFiles', 'IndexController@productFiles');
Route::get('products', 'IndexController@products');
Route::get('getSubmenu/{id}', 'CommonController@getSubmenu');
Route::get('showProducts/{id}', 'IndexController@showProducts');
//pagination for shopping product page
Route::get('laravel-ajax-pagination',array('as'=>'ajax-pagination','uses'=>'IndexController@productList'));
Route::get('order/{parameter}', 'IndexController@order');
Route::get('productDetail/{id}', 'IndexController@productDetail');
//user routes => for basket //Mr shiri
Route::group(['prefix' => 'user'], function () {
    Route::post('addToBasket', 'UserController@addToBasket');
    Route::get('getBasketCountNotify', 'UserController@getBasketCountNotify');
    Route::get('getBasketTotalPrice', 'UserController@getBasketTotalPrice');
    Route::get('getBasketContent', 'UserController@getBasketContent');
    Route::post('removeItemFromBasket', 'UserController@removeItemFromBasket');
    Route::post('orderFixed', 'UserController@orderFixed');
    Route::post('addOrSubCount', 'UserController@addOrSubCount');
    Route::post('orderRegistration', 'UserController@orderRegistration');
    Route::post('addToSeenCount', 'UserController@addToSeenCount');
    Route::post('addCommentForEachProduct','UserController@addCommentForEachProduct');
    Route::post('showJson','UserController@showJson');
});
//Auth::routes();
// Authentication Routes...
Route::get('login', 'IndexController@login')->name('login');//rayat 20-9-96 //show register and login form
Route::post('login', 'Auth\LoginController@login');//rayat 20-9-96
// Registration Routes...
Route::post('register', 'IndexController@register');//rayat 20-9-96
Route::get('captcha', 'IndexController@createCaptchaImage');
Route::get('town/{cid}', 'IndexController@town');
// Password Reset Routes...
Route::get('reset', 'Auth\ForgotPasswordController@showLinkRequestForm');//rayat 20-9-96
Route::post('email', 'Auth\ForgotPasswordController@sendResetLinkEmail');//rayat 20-9-96
Route::get('reset/{token}', 'Auth\ResetPasswordController@showResetForm');//rayat 20-9-96
Route::post('reset', 'Auth\ResetPasswordController@reset');//rayat 20-9-96

Route::group(['middleware' => ['auth']], function () {
    Route::get('/panel', 'IndexController@index');
    //admin routes
    Route::group(['prefix' => 'admin'], function () {
        //categories
        Route::get('addCategory', 'CategoryController@addCategory');//show add category view
        Route::get('categoriesManagement', 'CategoryController@categoriesManagement');//show view of all category
        Route::post('addNewCategory','CategoryController@addNewCategory');// add new category in database
        Route::get('editCategory/{id}', 'CategoryController@editCategory');//this route is related to edit main category
        Route::get('showSubCategory/{id}', 'CategoryController@showSubCategory');//this route is related to edit sub category
        Route::post('editCategoryPicture', 'CategoryController@editCategoryPicture');//this route is related to edit category picture
        Route::post('editCategoryTitle', 'CategoryController@editCategoryTitle');//this route is related ti edit category title
        Route::post('enableOrDisableCategory', 'CategoryController@enableOrDisableCategory');//this route is related to make categories enable or disable
        //units
        Route::get('addUnit', 'UnitController@addUnit');//show add unit view
        Route::get('unitCountManagement', 'UnitController@unitCountManagement');//show view of all units and subUnits
        Route::post('addNewUnit', 'UnitController@addNewUnit');//show view of all units and subUnits
        Route::get('subUnitManagement/{id}', 'UnitController@subUnitManagement');//show view of all units and subUnits
        Route::get('editUnitCount/{id}', 'UnitController@editUnitCount');
        Route::post('editUnitCountTitle', 'UnitController@editUnitCountTitle');
        Route::post('enableOrDisableUnitCount', 'UnitController@enableOrDisableUnitCount');
        Route::post('enableOrDisableSubUnitCount', 'UnitController@enableOrDisableSubUnitCount');
        //product
        Route::get('addProduct', 'ProductController@addProduct');//show add product view
        Route::get('productsManagement', 'ProductController@productsManagement')->name('productsManagement');//show view of all product's details
        Route::post('addNewProduct', 'ProductController@addNewProduct');// add new product in database
        Route::post('updateProduct', 'ProductController@updateProduct');// update Product in database
        Route::get('productDetails/{id}', 'ProductController@productDetailsGet');
        Route::post('changeProductStatus/{parameter}', 'ProductController@changeProductStatus');
        Route::get('deleteVideo', 'ProductController@deleteVideo');
        //images product
        Route::get('deleteProductPicture/{id}', 'ProductController@deleteProductPicture');//use in updating product (product details blade)
        //users
        Route::get('usersManagement', 'UserController@usersManagement');//show view of all customer's details
        //orders
        Route::get('ordersManagement', 'OrderController@ordersManagement');//show view of all orders
        Route::get('adminShowFactor/{id}', 'OrderController@adminShowFactor');
        Route::get('checkOrders', 'OrderController@checkOrders');
        Route::get('checkOrderStatus','OrderController@checkOrderStatus');
        Route::post('changeOrderStatus','OrderController@changeOrderStatus');
        Route::get('oldOrders','OrderController@oldOrders');
        //deliveryMan
        Route::get('addDeliveryMan', 'DeliveryManController@addDeliveryMan');//show add DeliveryMan view
        Route::get('deliveryMansManagement', 'DeliveryManController@deliveryMansManagement');//show view of all deliveryMans's details

        //payment type routes
        Route::get('addPaymentType', 'PaymentTypeController@addPaymentType');//this route is related to return add payment type blade
        Route::post('addNewPaymentTypes', 'PaymentTypeController@addNewPaymentTypes');
        Route::get('paymentTypesManagement', 'PaymentTypeController@paymentTypesManagement');
        Route::get('editPaymentType/{id}', 'PaymentTypeController@editPaymentType');
        Route::post('editPaymentTypeTitle', 'PaymentTypeController@editPaymentTypeTitle');
        //printer route
        Route::get('connectToPrinter', 'OrderController@connectToPrinter');
    });
    //end admin panel routes
    //user panel routes
    Route::group(['prefix' => 'user'], function () {
        Route::get('userOrders/{parameter}', 'UserController@userOrders')->name('userOrders');
        Route::get('orderDetails/{id}', 'UserController@orderDetails');
        Route::get('userShowFactor/{id}', 'UserController@userShowFactor');
        Route::get('changePassword', 'UserController@changePassword');
        Route::post('saveNewPassword', 'UserController@saveNewPassword');
        Route::post('detectWhatToDo','UserController@detectWhatToDo');
       // Route::get('scoreDetails/{id}',['as' => 'scoreDetails' , 'uses' => 'UserController@scoreDetails']);
        Route::get('scoreDetails/{id}','UserController@scoreDetails');
        Route::get('commentDetails/{id}','UserController@commentDetails');
        Route::post('addScore','UserController@addScore');
        Route::get('checkScore','UserController@checkScore');

    });
    //end user panel routes
    Route::post('logout', 'Auth\LoginController@logout');//rayat 20-9-96
    Route::get('logout', 'Auth\LoginController@logout');//rayat 20-9-96
});
