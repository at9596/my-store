<?php

namespace Webkul\EnhancedWishlistCompare\Providers;

use Webkul\Core\Providers\CoreModuleServiceProvider;
use Webkul\EnhancedWishlistCompare\Models\EnhancedWishlistCompareCount;
/**
 * Module Service Provider
 *
 * Registers module models with the Concord module system.
 */

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    /**
     * Models.
     *
     * These models will be registered and resolved via proxies.
     *
     * @var array
     */
    protected $models = [
        EnhancedWishlistCompareCount::class,
    ];
}
