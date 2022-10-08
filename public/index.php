<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/../bootstrap.php';

define('APPNAME', 'My Phonebook');

session_start();

$router = new \Bramus\Router\Router();

// Auth routes
$router->get('/logout', '\App\Controllers\Auth\LoginController@logout');
$router->get('/register', '\App\Controllers\Auth\RegisterController@showRegisterForm');
$router->post('/register', '\\App\Controllers\Auth\RegisterController@register');
$router->get('/login', '\App\Controllers\Auth\LoginController@showLoginForm');
$router->post('/login', '\App\Controllers\Auth\LoginController@login');

// // home
$router->get('/', '\App\Controllers\HomeController@index'); 
$router->get('/home', '\App\Controllers\HomeController@index');

// product
$router->get('/product?.*', '\App\Controllers\ProductController@index'); 

// detail

$router->get('/detail?.*', '\App\Controllers\ProductDetailController@index'); 

// search
$router->get('/search?.*', '\App\Controllers\ProductController@search'); 

// add to cart
$router->post('/addCart', '\App\Controllers\CartController@addCart'); 

// show Xhtml
$router->get('/getCart?.*', '\App\Controllers\XhtmlController@getCart'); 
$router->get('/showItem', '\App\Controllers\XhtmlController@showCart');
$router->get('/showNotify?.*', '\App\Controllers\XhtmlController@showNotify');
$router->post('/watchedNotify', '\App\Controllers\XhtmlController@watchNotify');
$router->get('/watchedNotify', '\App\Controllers\XhtmlController@watchNotify');


// show cart
$router->get('/showCart', '\App\Controllers\CartController@index'); 
$router->post('/cart/deleteItem?.*', '\App\Controllers\CartController@deleteItem');
$router->get('/cart/deleteItem?.*', '\App\Controllers\CartController@deleteItem');
$router->post('/cart/updateQuantity?.*', '\App\Controllers\CartController@updateItem');


// order
$router->post('/cart/createOrder?.*', '\App\Controllers\OrderController@createOrder');
$router->get('/order/cancelOrder?.*', '\App\Controllers\OrderController@cancelOrder');


$router->get('/test', '\App\Controllers\TestController@index');
$router->post('/upload', '\App\Controllers\TestController@upload');



// show order history

$router->get('/showOrder', '\App\Controllers\OrderController@index'); 


// profile
$router->get('/profile', '\App\Controllers\ProfileController@index');
$router->post('/profile/update/info?.*', '\App\Controllers\ProfileController@updateUser'); 
$router->post('/profile/update/password?.*', '\App\Controllers\ProfileController@updatePassWord'); 
$router->post('/profile/update/avatar?.*', '\App\Controllers\ProfileController@updateAvatar'); 




// admin
$router->get('/admin', '\App\Controllers\Admin\AccountController@index'); 

// admin account
$router->get('/admin/account', '\App\Controllers\Admin\AccountController@index'); 
$router->post('/admin/updateAcc', '\App\Controllers\Admin\AccountController@updateAccount'); 
$router->post('/admin/deleteAcc', '\App\Controllers\Admin\AccountController@deleteAccount'); 

// admin user
$router->get('/admin/user', '\App\Controllers\Admin\UserController@index'); 
$router->post('/admin/updateUser', '\App\Controllers\Admin\UserController@updateUser'); 
$router->post('/admin/deleteUser', '\App\Controllers\Admin\UserController@deleteUser'); 

// admin product
$router->get('/admin/product', '\App\Controllers\Admin\ProductController@index'); 
$router->post('/admin/product/create', '\App\Controllers\Admin\ProductController@addProduct');
$router->post('/admin/product/update', '\App\Controllers\Admin\ProductController@updateProduct');
$router->post('/admin/product/delete?.*', '\App\Controllers\Admin\ProductController@deleteProduct'); 


// admin category
$router->get('/admin/category', '\App\Controllers\Admin\CategoryController@index'); 
$router->post('/admin/category/add', '\App\Controllers\Admin\CategoryController@add');
$router->post('/admin/category/delete?.*', '\App\Controllers\Admin\CategoryController@delete');
$router->post('/admin/category/update?.*', '\App\Controllers\Admin\CategoryController@update');

// admin order

$router->get('/admin/order', '\App\Controllers\Admin\OrderController@index'); 
$router->get('/admin/order?.*', '\App\Controllers\Admin\OrderController@index'); 
$router->post('/admin/order/confirmOrder', '\App\Controllers\Admin\OrderController@confirm');
$router->post('/admin/order/cancelOrder', '\App\Controllers\Admin\OrderController@cancel');

// admin statis
$router->get('/admin/statis', '\App\Controllers\Admin\StatisController@index');
$router->post('/admin/statis?.*', '\App\Controllers\Admin\StatisController@index'); 

// test captcha

// $router->get('/test', '\App\Controllers\captchaController@index');


$router->set404('\App\Controllers\Controller@sendNotFound');

$router->run();
