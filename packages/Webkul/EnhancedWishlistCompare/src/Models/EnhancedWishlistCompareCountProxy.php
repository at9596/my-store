<?php

namespace Webkul\EnhancedWishlistCompare\Models;

use Webkul\Core\Eloquent\Proxy;

class EnhancedWishlistCompareCountProxy extends Proxy
{
    public static function getModelClass()
    {
        return EnhancedWishlistCompareCount::class;
    }
}
