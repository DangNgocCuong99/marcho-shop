<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;
// use Auth;

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



// ROUTE FRONTEND
Route::group([
    'namespace' => 'Frontend',
], function () {
    // Home
    Route::get('/', 'HomeController@index')->name('home');

    // Blog
    Route::get('blog', 'BlogController@index')->name('blog.index');
    Route::get('blog/{blog:slug}', 'BlogController@show')->name('blog.show');

    // Product
    Route::get('product', 'ProductController@index')->name('product.index');
    Route::get('product/{product:slug}', 'ProductController@show')->name('product.show');

    // Product Attribute
    Route::get('product-attribute/{productAttribute}', 'ProductController@quantity')->name('product.quantity');

    // Contact
    Route::resource('contact', 'ContactController')->only([
        'index', 'store',
    ]);

    // Frontend Auth
    Route::group([
        'middleware' => ['auth'],
    ], function () {
        // Blog Comment
        Route::resource('blog.comment', 'CommentController')->only([
            'store',
        ]);

        // Product Review
        Route::resource('product.review', 'ReviewController')->only([
            'store',
        ]);

        // Favorite
        Route::group([
            'prefix' => 'favorite',
        ], function () {
            Route::get('/', 'FavoriteController@index')->name('favorite.index');
            Route::get('list', 'FavoriteController@list')->name('favorite.list');
            Route::get('{product}', 'FavoriteController@favorite')->name('favorite.favorite');
        });

        // Cart
        Route::group([
            'prefix' => 'cart',
        ], function () {
            // Show Cart
            Route::get('/', 'CartController@index')->name('cart.index');
            // List Cart
            Route::get('list', 'CartController@list')->name('cart.list');
            // Add Cart
            Route::post('store', 'CartController@store')->name('cart.store');
            // Discount Cart
            Route::post('discount', 'CartController@discount')->name('cart.discount');
            // Update Cart
            Route::post('update/{id}', 'CartController@update')->name('cart.update');
            // Remove Cart
            Route::post('destroy/{id}', 'CartController@destroy')->name('cart.destroy');
            // Clear All Cart
            Route::post('clear', 'CartController@clear')->name('cart.clear');
        });

        // Checkout
        Route::group([
            'prefix' => 'checkout',
        ], function () {
            // Checkout
            Route::get('/', 'CheckoutController@index')->name('checkout.index');
            Route::post('districts', 'CheckoutController@districts')->name('checkout.districts');
            Route::post('wards', 'CheckoutController@wards')->name('checkout.wards');
        });

        // Profile
        Route::group([
            'prefix' => 'user',
            'as' => 'user.'
        ], function () {
            // Profile
            Route::get('/profile', 'ProfileController@index')->name('profile');
            Route::get('/password', 'ProfileController@password')->name('password');
            Route::get('/address', 'ProfileController@address')->name('address');
            // Route::post('/addressCreate', 'ProfileController@addressCreate')->name('address.create');
            Route::put('/{profile}', 'ProfileController@update')->name('update');

            // Order
            Route::get('order/trash', 'OrderController@trash')->name('order.trash');
            Route::put('order/{order}/cancel', 'OrderController@cancelOrder')->name('order.cancel');
            Route::resource('order', 'OrderController');
        });
    });
});

// ROUTE ADMIN
Route::group([
    'namespace' => 'Admin',
    'as' => 'admin.',
    'prefix' => 'admin',
    'name' => 'admin',
    'middleware' => ['auth', 'has_any_permission'],
], function () {
    // Dashboard
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    //Profile
    Route::get('profile', 'ProfileController@index')->name('profile');
    Route::put('profile/{profile}', 'ProfileController@update')->name('profile.update');

    // Category
    Route::get('category/list', 'CategoryController@list')->name('category.list');
    Route::resource('category', 'CategoryController', ['except' => ['show']]);

    // Attribute
    Route::get('attribute/list', 'AttributeController@list')->name('attribute.list');
    Route::resource('attribute', 'AttributeController', ['except' => ['show']]);

    // Attribute Values
    Route::get('attribute/{attribute}/value/list', 'AttributeValueController@list')->name('attribute.value.list');
    Route::resource('attribute.value', 'AttributeValueController', ['except' => ['show', 'create', 'edit', 'update']]);

    // Blog
    Route::get('blog/list', 'BlogController@list')->name('blog.list');
    Route::resource('blog', 'BlogController', ['except' => ['show']]);

    // Comment
    Route::get('blog/{blog}/comment/list', 'CommentController@list')->name('comment.list');
    Route::resource('blog.comment', 'CommentController')->only([
        'index', 'destroy', 'edit', 'update'
    ]);

    // Product
    Route::get('product/list', 'ProductController@list')->name('product.list');
    Route::resource('product', 'ProductController', ['except' => ['show']]);

    // Review
    Route::get('product/{product}/review/list', 'ReviewController@list')->name('review.list');
    Route::resource('product.review', 'ReviewController', ['except' => ['show']]);

    // Product Attributes
    Route::get('product/{product}/attribute/list', 'ProductAttributeController@list')->name('product.attribute.list');
    Route::resource('product.attribute', 'ProductAttributeController', ['except' => ['show']]);

    // Order
    Route::get('order/list', 'OrderController@list')->name('order.list');
    Route::resource('order', 'OrderController', ['except' => ['show', 'create', 'store', 'destroy']]);

    // User
    Route::get('user/list', 'UserController@list')->name('user.list');
    Route::resource('user', 'UserController', ['except' => ['show', 'create', 'store']]);

    // Role
    Route::get('role/list', 'RoleController@list')->name('role.list');
    Route::get('role/permissionList', 'RoleController@permissionList')->name('role.permissionList');
    Route::resource('role', 'RoleController', ['except' => ['show']]);

    // Permission
    Route::get('permission/list', 'PermissionController@list')->name('permission.list');
    Route::resource('permission', 'PermissionController', ['except' => ['show', 'create', 'store', 'edit', 'update']]);

    // Slider
    Route::get('slider/list', 'SliderController@list')->name('slider.list');
    Route::resource('slider', 'SliderController', ['except' => ['show']]);
});

// FILE MANAGER
Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth'],], function () {
    Route::group(['prefix' => 'filemanager'], function () {
        Lfm::routes();
    });
});

Auth::routes([
    'verify' => true
]);
