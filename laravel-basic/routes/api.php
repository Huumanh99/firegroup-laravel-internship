<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//delete products on shopify
Route::get('/deleteProductWebhook', [ShopifyController::class, 'deleteProductWebhook']);
Route::post('/deletePr', [ShopifyController::class, 'deleteProductOnShopify']);

//create products on shopify
Route::post('/createProduct', [ShopifyController::class, 'createProductOnShopify']);
Route::get('/createWebhook', [ShopifyController::class, 'createWebhook']);

//update products on shopify
Route::post('/updatePro', [ShopifyController::class, 'updateProductOnShopify']);
Route::get('/updateProduct', [ShopifyController::class, 'updateProduct']);


//delete product local
Route::get('/shopify/delete/{id}', [ShopifyController::class, 'deleteProducLocal']);