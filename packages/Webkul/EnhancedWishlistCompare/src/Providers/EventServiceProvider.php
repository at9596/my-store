<?php

namespace Webkul\EnhancedWishlistCompare\Providers;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
class EventServiceProvider extends ServiceProvider {
    protected $listen = [
        'customer.compare.create.after' => [
            'Webkul\EnhancedWishlistCompare\Listeners\CompareEventListener@created',
        ],

        'customer.compare.delete.after' => [
            'Webkul\EnhancedWishlistCompare\Listeners\CompareEventListener@deleted',
        ],
    ];
}
