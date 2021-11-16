<?php

use App\Http\Controllers\Backend\BackendController;
use \Backend\OrderController;
use \Backend\PaymentMethodController;
use \Backend\ShippingCompanyController;
use App\Http\Controllers\CustomerSearchController;
use App\Http\Controllers\Frontend\CustomerController as FrontendCustomerController;
use \Backend\CustomerAddressController;
use \Backend\CityController;
use \Backend\CountryController;
use \Backend\StateController;
use \Backend\AdminController;
use \Backend\CustomerController;
use \Backend\UserController;
use \Backend\ProductCoponController;
use \Backend\ProductReviewController;
use \Backend\CategoryController;
use \Backend\ProductController;
use \Backend\TagController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\PaymentController as FrontendPaymentController;
use \Frontend\PaymentController;
use Illuminate\Support\Facades\Auth;
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
//دا علشان يبغت ايميل تاكيد عند التسجيل
Auth::routes(['verify'=>true]);

// Route::get('/', function () {
//     return view('frontend.index');
// });

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/',                 [FrontendController::class, 'index'   ])->name('frontend.index');
Route::get('/cart',             [FrontendController::class, 'cart'    ])->name('frontend.cart');
Route::get('/wishlist',         [FrontendController::class, 'wishlist'])->name('frontend.wishlist');
Route::get('/shop/{slug?}',     [FrontendController::class, 'shop'    ])->name('frontend.shop');
Route::get('/shop/tag/{slug?}', [FrontendController::class, 'shop_tag'])->name('frontend.shop_tag');
Route::get('/product/{slug}',   [FrontendController::class, 'product' ])->name('frontend.product');


Route::group(['middleware' => ['roles', 'role:customer'] ], function(){
    Route::get('/dashboard',        [FrontendCustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/profile',          [FrontendCustomerController::class, 'profile'])->name('customer.profile');
    Route::patch('/update_profile', [FrontendCustomerController::class, 'update_profile'])->name('customer.update_profile');
    Route::get('/remove_profile_image', [FrontendCustomerController::class, 'remove_profile_image'])->name('customer.remove_profile_image');
    Route::get('/addresses',        [FrontendCustomerController::class, 'addresses'])->name('customer.addresses');
    Route::get('/orders',           [FrontendCustomerController::class, 'orders'])->name('customer.orders');


    Route::group(['middleware' => 'check_cart' ], function(){
        Route::get('/checkout',                         [FrontendPaymentController::class, 'checkout'])->name('frontend.checkout');
        Route::post('/checkout/payment',                [FrontendPaymentController::class, 'checkout_now'])->name('checkout.payment');
        Route::get('/checkout/{order_id}/cancelled',    [FrontendPaymentController::class, 'cancelled'])->name('checkout.cancel');
        Route::get('/checkout/{order_id}/completed',    [FrontendPaymentController::class, 'completed'])->name('checkout.complete');
        Route::get('/checkout/webhook/{order?}/{env?}', [FrontendPaymentController::class, 'webhook'])->name('checkout.webhook.ipn');
    });
});
//==========================================================================================================
//================================= Admin Dashboard  =======================================================
//==========================================================================================================
Route::group(['prefix' => 'admin', 'as'=>'admin.' ], function(){

    Route::group(['middleware' => 'guest' ], function(){

        Route::get('/login',               [BackendController::class, 'login'    ])->name('login');
        Route::get('/forget_password',     [BackendController::class, 'forget_password'])->name('forget_password');
    });

    //==========================================================================================================
    Route::group(['middleware' => ['roles', 'role:superAdmin|admin|user'] ], function(){

        Route::get('/',                     [BackendController::class, 'index'              ])->name('index_route');
        Route::get('/index',                [BackendController::class, 'index'              ])->name('index');
        Route::get('/mySettings',           [BackendController::class, 'mySettings'         ])->name('mySettings');
        Route::PATCH('/update_mySettings',         [BackendController::class, 'update_mySettings'  ])->name('update_mySettings');

        Route::post('/categories/removeImage', 'Backend\CategoryController@removeImage')->name('categories.removeImage');
        Route::resource('categories',           CategoryController::class);

        Route::post('/products/removeImage','Backend\ProductController@removeImage')->name('products.removeImage');
        Route::resource('products',         ProductController::class);
        Route::resource('tags',             TagController::class);
        Route::resource('productCopons',    ProductCoponController::class);
        Route::resource('productReviews',   ProductReviewController::class);

        Route::resource('admins'            ,AdminController::class);
        Route::post('/admins/removeImage', 'Backend\AdminController@removeImage')->name('admins.removeImage');

        Route::resource('users'             ,UserController::class);
        Route::post('/users/removeImage',   'Backend\UserController@removeImage')->name('users.removeImage');

        Route::resource('customers'                 ,CustomerController::class);
        Route::post('/customers/removeImage',       'Backend\CustomerController@removeImage')->name('customers.removeImage');
        Route::get('/get_customer_customerSearch',  [CustomerSearchController::class, 'index'    ])->name('customers.get_customer');
        Route::get('/get_state_customerSearch',     [CustomerSearchController::class, 'get_state_customerSearch'    ])->name('customers.get_state_customerSearch');
        Route::get('/get_city_customerSearch',      [CustomerSearchController::class, 'get_city_customerSearch'    ])->name('customers.get_city_customerSearch');


        Route::resource('customer_addresses'    ,CustomerAddressController::class);
        Route::resource('countries'             ,CountryController::class);
        Route::resource('states'                ,StateController::class);
        Route::resource('cities'                ,CityController::class);
        Route::resource('shipping_companies'    ,ShippingCompanyController::class);
        Route::resource('payment_methods'       ,PaymentMethodController::class);
        Route::resource('orders'                ,OrderController::class);

    });

});
