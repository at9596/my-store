<?php

namespace Webkul\EnhancedWishlistCompare\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\EnhancedWishlistCompare\Contracts\EnhancedWishlistCompareCount as EnhancedWishlistCompareCountContract;

class EnhancedWishlistCompareCount extends Model implements EnhancedWishlistCompareCountContract
{
    protected $table = 'enhanced_wishlist_compare_counts';

    protected $fillable = [
        'customer_id',
        'wishlist_count',
        'compare_count',
    ];
}
