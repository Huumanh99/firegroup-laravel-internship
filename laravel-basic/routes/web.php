<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ShopifyController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Weidner\Goutte\GoutteFacade;

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

// Route::get('/', [UserController::class, 'index'])->name('users');

Route::get('/', [AuthController::class, 'login']);

// Route Users
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/users/create', [UserController::class, 'create'])->name('createUser');
Route::post('/users/create-user', [UserController::class, 'createUser']);
Route::post('/users/add-image', [UserController::class, 'addImage']);
Route::get('/users/edit/{id}', [UserController::class, 'edit']);
Route::post('/users/update/{id}', [UserController::class, 'update']);
Route::get('/users/delete/{id}', [UserController::class, 'delete']);
Route::get('/users/detail/{id}', [UserController::class, 'detail']);

//export
Route::get('/export', [UserController::class, 'export'])->name('export');

Route::get('/users/search', [UserController::class, 'search']);

//Route products
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/create', [ProductController::class, 'create'])->name('createProduct');
Route::post('/products/create-product', [ProductController::class, 'createProduct']);
Route::get('/products/edit/{id}', [ProductController::class, 'edit']);
Route::post('/products/update/{id}', [ProductController::class, 'update']);
Route::get('/products/delete/{id}', [ProductController::class, 'delete']);
Route::get('/products/detail/{id}', [ProductController::class, 'detail']);

Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/products/detail/{id}', [ProductController::class, 'detail']);
Route::post('/products/fitter/{keyword}', [ProductController::class, 'fitter']);

//Shopify
Route::get('/shopify', [ShopifyController::class, 'shopify']);
Route::get('/shopify/url', [ShopifyController::class, 'generateCode']);
Route::get('/page', [ShopifyController::class, 'pageTest']);

//Route Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/authenticate', [AuthController::class, 'authenticate']);


Route::get('/posts', [PostController::class, 'index'])->name('posts');
Route::get('/posts/edit/{id}', [PostController::class, 'edit']);
Route::post('/posts/update/{id}', [PostController::class, 'update']);
Route::get('/posts/delete/{id}', [PostController::class, 'delete']);
Route::get('/posts/detail/{id}', [PostController::class, 'detail']);

Route::post('/posts/change-status', [PostController::class, 'changeStatus']);

Route::post('/posts/fitter/{keyword}', [PostController::class, 'fitter']);