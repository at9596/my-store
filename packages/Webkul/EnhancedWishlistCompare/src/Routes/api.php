<?php

use Illuminate\Support\Facades\Route;
use Webkul\EnhancedWishlistCompare\Http\Controllers\EnhancedController;

Route::group(['prefix' => 'api/enhanced', 'middleware' => ['web', 'customer']], function () {
    Route::get('/compare/count', [EnhancedController::class, 'compareCount']);
});