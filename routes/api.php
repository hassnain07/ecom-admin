<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\WebUsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/getProducts', [ClientController::class, 'getProducts']);
Route::get('/getCategories', [ClientController::class, 'getCategories']);
Route::get('/getSingleProduct/{id}', [ClientController::class, 'getSingleProduct']);
Route::post('/placeOrder',[OrdersController::class,'placeOrder']);
Route::get('/searchProducts', [ClientController::class, 'getSearchProducts']);
Route::get('/store-products', [ClientController::class, 'getStoreProducts']);

// auth
Route::post('/registerUser', [WebUsersController::class, 'store']);

// review
Route::post('/submitReview', [ClientController::class, 'submitReview']);