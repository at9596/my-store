<?php

namespace Webkul\EnhancedWishlistCompare\Http\Controllers;

use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\Customer\Repositories\CompareItemRepository;
use Illuminate\Support\Facades\DB;

class EnhancedController
{
    protected $wishlistRepository;
    protected $compareItemRepository;

    public function __construct(WishlistRepository $wishlistRepository,CompareItemRepository $compareItemRepository ) 
    {
        $this->wishlistRepository = $wishlistRepository;
        $this->compareItemRepository = $compareItemRepository;
    }
    public function wishlistCount()
    {
        $customer = auth()->guard('customer')->user();

        if (! $customer) {
            return response()->json(['count' => 0]);
        }

        $count = $this->wishlistRepository->count([
            'customer_id' => $customer->id,
        ]);

        DB::table('enhanced_wishlist_compare_counts')->updateOrInsert(
            ['customer_id' => $customer->id],
            [
                'wishlist_count' => $count,
                'updated_at'     => now(),
                'created_at'     => now(),
            ]
        );

        return response()->json([
            'count' => $count
        ]);
    }

    public function compareCount()
    {
        $customer = auth()->guard('customer')->user();

        if (! $customer) {
            return response()->json(['count' => 0]);
        }

        $count = $this->compareItemRepository->count([
            'customer_id' => $customer->id,
        ]);

        DB::table('enhanced_wishlist_compare_counts')->updateOrInsert(
            ['customer_id' => $customer->id],
            [
                'compare_count' => $count,
                'updated_at'    => now(),
                'created_at'    => now(),
            ]
        );

        return response()->json([
            'count' => $count
        ]);
    }
}