<?php

use App\Http\Controllers\Api\Accounting\AccountController;
use App\Http\Controllers\Api\Accounting\AccountTitleController;
use App\Http\Controllers\Api\Config\CategoryController;
use App\Http\Controllers\Api\Config\ItemLocationController;
use App\Http\Controllers\Api\Config\PaymentMethodController;
use App\Http\Controllers\Api\Config\ProductController;
use App\Http\Controllers\Api\Config\SubCategoryController;
use App\Http\Controllers\Api\Crm\ContactController;
use App\Models\AccountTitle;
use App\Models\ItemLocation;
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

Route::middleware([])->group(function () {
    // Route::get('categories', CategoryController::class)->name('api.category');
    // Route::get('sub-categories', SubCategoryController::class)->name('api.sub-category');
    // Route::get('products', ProductController::class)->name('api.product');
    // Route::get('contacts', ContactController::class)->name('api.contact');
    // Route::get('location', ItemLocationController::class)->name('api.item-location');
    // Route::get('payments', PaymentMethodController::class)->name('api.payment-methods');
    // Route::get('accounting/accounts', AccountController::class)->name('api.accounting-accounts');
    // Route::get('accounting/account-titles', AccountTitleController::class)->name('api.account-titles');
});
