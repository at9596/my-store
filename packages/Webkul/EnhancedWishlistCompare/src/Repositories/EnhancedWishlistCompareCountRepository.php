<?php

namespace Webkul\EnhancedWishlistCompare\Repositories;

use Webkul\Core\Eloquent\Repository;
use Webkul\EnhancedWishlistCompare\Contracts\EnhancedWishlistCompareCount as EnhancedWishlistCompareCountContract;

class EnhancedWishlistCompareCountRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EnhancedWishlistCompareCountContract::class;
    }
}
