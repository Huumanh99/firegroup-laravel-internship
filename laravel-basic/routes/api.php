<?php

use App\Http\Controllers\JwtAuthController;
use App\Http\Controllers\ShopifyController;
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
Route::get('/register', function () {
    return view("admin.register");
});

Route::get('/login', function () {
    return view("admin.login");
});


//Test API
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    Route::post('/admin/register', [JwtAuthController::class, 'register'])->name("register");

    Route::post('/admin/login', [JwtAuthController::class, 'login'])->name("login");
    
    Route::get('/admin/user', [JwtAuthController::class, 'user'])->middleware('getUserApi');

    Route::post('/logout', [JwtAuthController::class, 'logout']);
    Route::post('/refresh', [JwtAuthController::class, 'refresh']);
    Route::get('/user-profile', [JwtAuthController::class, 'userProfile']);
    Route::post('/change-pass', [JwtAuthController::class, 'changePassWord']);    
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//delete products on shopify
Route::get('/deleteProductWebhook', [ShopifyController::class, 'deleteProductWebhook']);
Route::post('/deleteProductOnShopify', [ShopifyController::class, 'deleteProductOnShopify']);

//create products on shopify
Route::any('/createProductOnShopify', [ShopifyController::class, 'createProductOnShopify']);
Route::get('/createWebhook', [ShopifyController::class, 'createWebhook']);

//update products on shopify
Route::post('/updateProductOnShopify', [ShopifyController::class, 'updateProductOnShopify']);
Route::get('/updateProduct', [ShopifyController::class, 'updateProduct']);


//delete product local
Route::get('/shopify/delete/{id}', [ShopifyController::class, 'deleteProducLocal']);

