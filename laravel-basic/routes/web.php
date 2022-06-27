<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\User;
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

Route::get('/', [UserController::class, 'index'])->name('users');

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
Route::get('/products/fitter/{keyword}', [ProductController::class, 'fitter']);

