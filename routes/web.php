<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ParentCategoriesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductStatusController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [dashboardController::class,'index'])->name('dashboard');


    // Roles
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('/roles-data', [RoleController::class, 'getData'])->name('roles.getData');
    Route::post('roles/bulk-delete', [RoleController::class, 'bulkDelete'])->name('roles.bulkDelete');
    
    // Permissions
    Route::get('/permissions/create', [PermissionsController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionsController::class, 'store'])->name('permissions.store');
    Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/{id}/edit', [PermissionsController::class, 'edit'])->name('permissions.edit');
    Route::put('/permissions', [PermissionsController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{id}', [PermissionsController::class, 'destroy'])->name('permissions.destroy');
    Route::get('/permissions-data', [PermissionsController::class, 'getData'])->name('permissions.getData');

    // Users
    Route::get('users',[UserController::class, 'index'])->name('users.index');
    Route::get('users/create',[UserController::class, 'create'])->name('users.create');
    Route::post('users/store',[UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('users-data', [UserController::class, 'getUsersData'])->name('users.data');
    Route::post('users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulkDelete');

 
    // Categories
    Route::get('parentCategories',[ParentCategoriesController::class, 'index'])->name('parentCategories.index');
    Route::get('parentCategories/create',[ParentCategoriesController::class, 'create'])->name('parentCategories.create');
    Route::post('parentCategories/store',[ParentCategoriesController::class, 'store'])->name('parentCategories.store');
    Route::get('parentCategories/{id}/edit', [ParentCategoriesController::class, 'edit'])->name('parentCategories.edit');
    Route::delete('parentCategories/{id}', [ParentCategoriesController::class, 'destroy'])->name('parentCategories.destroy');
    Route::put('parentCategories/{id}', [ParentCategoriesController::class, 'update'])->name('parentCategories.update');
    Route::get('parentCategories-data', [ParentCategoriesController::class, 'getCategories'])->name('parentCategories.data');
    Route::post('parentCategories/bulk-delete', [ParentCategoriesController::class, 'bulkDelete'])->name('parentCategories.bulkDelete');


    // Categories
    Route::get('categories',[CategoriesController::class, 'index'])->name('categories.index');
    Route::get('categories/create',[CategoriesController::class, 'create'])->name('categories.create');
    Route::post('categories/store',[CategoriesController::class, 'store'])->name('categories.store');
    Route::get('categories/{id}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
    Route::delete('categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
    Route::put('categories/{id}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::get('categories-data', [CategoriesController::class, 'getCategories'])->name('categories.data');
    Route::post('categories/bulk-delete', [CategoriesController::class, 'bulkDelete'])->name('categories.bulkDelete');
    
    // Stores
    Route::get('stores',[StoresController::class, 'index'])->name('stores.index');
    Route::get('stores/create',[StoresController::class, 'create'])->name('stores.create');
    Route::post('stores/store',[StoresController::class, 'store'])->name('stores.store');
    Route::get('stores/{id}/edit', [StoresController::class, 'edit'])->name('stores.edit');
    Route::delete('stores/{id}', [StoresController::class, 'destroy'])->name('stores.destroy');
    Route::put('stores/{id}', [StoresController::class, 'update'])->name('stores.update');
    Route::get('stores-data', [StoresController::class, 'getStores'])->name('stores.data');
    Route::post('stores/bulk-delete', [StoresController::class, 'bulkDelete'])->name('stores.bulkDelete');
    Route::post('/stores/{id}/approve', [dashboardController::class, 'approve'])->name('stores.approve');

    // Products
    Route::get('products',[ProductsController::class, 'index'])->name('products.index');
    Route::get('products/create',[ProductsController::class, 'create'])->name('products.create');
    Route::post('products/store',[ProductsController::class, 'store'])->name('products.store');
    Route::get('products/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
    Route::delete('products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');
    Route::put('products/{id}', [ProductsController::class, 'update'])->name('products.update');
    Route::get('products-data', [ProductsController::class, 'getProducts'])->name('products.data');
    Route::post('products/bulk-delete', [ProductsController::class, 'bulkDelete'])->name('products.bulkDelete');
    Route::post('dc/create', [ProductsController::class, 'addDc'])->name('deliveryCharges.add');

    // Status
    Route::get('status',[StatusController::class, 'index'])->name('status.index');
    Route::get('status/create',[StatusController::class, 'create'])->name('status.create');
    Route::post('status/store',[StatusController::class, 'store'])->name('status.store');
    Route::get('status/{id}/edit', [StatusController::class, 'edit'])->name('status.edit');
    Route::delete('status/{id}', [StatusController::class, 'destroy'])->name('status.destroy');
    Route::put('status/{id}', [StatusController::class, 'update'])->name('status.update');
    Route::get('status-data', [StatusController::class, 'getStatuses'])->name('status.data');
    Route::post('status/bulk-delete', [StatusController::class, 'bulkDelete'])->name('status.bulkDelete');
    
    // Product Status
    Route::get('product-status',[ProductStatusController::class, 'index'])->name('product-status.index');
    Route::get('product-status/create',[ProductStatusController::class, 'create'])->name('product-status.create');
    Route::post('product-status/store',[ProductStatusController::class, 'store'])->name('product-status.store');
    Route::get('product-status/{id}/edit', [ProductStatusController::class, 'edit'])->name('product-status.edit');
    Route::delete('product-status/{id}', [ProductStatusController::class, 'destroy'])->name('product-status.destroy');
    Route::put('product-status/{id}', [ProductStatusController::class, 'update'])->name('product-status.update');
    Route::get('product-status-data', [ProductStatusController::class, 'getProductStatuses'])->name('product-status.data');
    Route::post('product-status/bulk-delete', [ProductStatusController::class, 'bulkDelete'])->name('product-status.bulkDelete');


    // Reviews
    Route::get('reviews',[ReviewController::class, 'index'])->name('reviews.index');
    Route::get('reviews-data', [ReviewController::class, 'getReviews'])->name('reviews.data');
    Route::get('test-reviews', [ReviewController::class, 'testReviews']);
    
    // Orders
    Route::get('orders',[OrdersController::class, 'index'])->name('orders.index'); 
    Route::post('orders/{id}/status', [OrdersController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('orders/{id}/show', [OrdersController::class, 'show'])->name('orders.show');
    Route::get('orders-data', [OrdersController::class, 'getOrders'])->name('orders.data');


});

// Include the authentication routes
require __DIR__.'/auth.php';