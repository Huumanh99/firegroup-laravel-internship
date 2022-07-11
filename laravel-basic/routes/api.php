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

Route::post('/createProduct', [ShopifyController::class, 'createProduct']);
Route::get('/createWebhook', [ShopifyController::class, 'createWebhook']);

Route::get('/updateProduct', [ShopifyController::class, 'updateProduct']);
Route::post('/updatePro', [ShopifyController::class, 'updatePro']);

Route::get('/deleteProductWebhook', [ShopifyController::class, 'deleteProductWebhook']);
Route::post('/deletePr', [ShopifyController::class, 'deletePr']);

//delete product shopify
Route::get('/shopify/delete/{id}', [ShopifyController::class, 'delete']);