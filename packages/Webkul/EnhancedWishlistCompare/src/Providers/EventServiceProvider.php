<?php

namespace Webkul\EnhancedWishlistCompare\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'customer.compare.create.after' => [
            'Webkul\EnhancedWishlistCompare\Listeners\CompareEventListener@sync',
        ],

        'customer.compare.create.before' => [
            'Webkul\EnhancedWishlistCompare\Listeners\CompareEventListener@sync',
        ],

        'customer.compare.delete.after' => [
            'Webkul\EnhancedWishlistCompare\Listeners\CompareEventListener@sync',
        ],

        'customer.compare.delete-all.after' => [
            'Webkul\EnhancedWishlistCompare\Listeners\CompareEventListener@sync',
        ],

        'customer.wishlist.create.before' => [
            'Webkul\EnhancedWishlistCompare\Listeners\CompareEventListener@sync',
        ],
        'customer.wishlist.create.after' => [
            'Webkul\EnhancedWishlistCompare\Listeners\CompareEventListener@sync',
        ],

        'customer.wishlist.update.after' => [
            'Webkul\EnhancedWishlistCompare\Listeners\CompareEventListener@sync',
        ],

        'customer.wishlist.delete.after' => [
            'Webkul\EnhancedWishlistCompare\Listeners\CompareEventListener@sync',
        ],

        'customer.wishlist.delete-all.after' => [
            'Webkul\EnhancedWishlistCompare\Listeners\CompareEventListener@sync',
        ],

        'customer.wishlist.move-to-cart.after' => [
            'Webkul\EnhancedWishlistCompare\Listeners\CompareEventListener@sync',
        ],
    ];
}
