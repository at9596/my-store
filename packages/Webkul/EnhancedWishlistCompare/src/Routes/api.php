<?php

use Illuminate\Support\Facades\Route;
use Webkul\EnhancedWishlistCompare\Http\Controllers\EnhancedController;

Route::group(['prefix' => 'api/enhanced', 'middleware' => ['web', 'customer']], function () {
    Route::get('/wishlist/count', [EnhancedController::class, 'wishlistCount'])->name('api.enhanced.wishlist.count');
    Route::get('/compare/count', [EnhancedController::class, 'compareCount'])->name('api.enhanced.compare.count');
});