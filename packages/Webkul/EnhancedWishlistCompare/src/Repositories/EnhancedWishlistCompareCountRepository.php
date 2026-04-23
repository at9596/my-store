<?php

namespace Webkul\EnhancedWishlistCompare\Repositories;

use Webkul\Core\Eloquent\Repository;

class EnhancedWishlistCompareCountRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return 'Webkul\EnhancedWishlistCompare\Contracts\EnhancedWishlistCompareCount';
    }
}
