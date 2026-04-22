<?php

namespace Webkul\EnhancedWishlistCompare\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompareEventListener
{
    public function sync($eventPayload = null): void
    {
        $customerId = $this->resolveCustomerId($eventPayload);

        if (! $customerId) {
            return;
        }

        $wishlistCount = DB::table('wishlists')
            ->where('customer_id', $customerId)
            ->count();

        $compareCount = DB::table('compare_items')
            ->where('customer_id', $customerId)
            ->count();

        DB::table('enhanced_wishlist_compare_counts')->updateOrInsert(
            ['customer_id' => $customerId],
            [
                'wishlist_count' => $wishlistCount,
                'compare_count'  => $compareCount,
                'updated_at'     => now(),
                'created_at'     => now(),
            ]
        );
    }

    protected function resolveCustomerId($eventPayload): ?int
    {
        if (is_object($eventPayload) && isset($eventPayload->customer_id)) {
            return (int) $eventPayload->customer_id;
        }

        if (is_numeric($eventPayload)) {
            $wishlistCustomerId = DB::table('wishlists')
                ->where('id', (int) $eventPayload)
                ->value('customer_id');

            if ($wishlistCustomerId) {
                return (int) $wishlistCustomerId;
            }
        }

        return Auth::guard('customer')->id();
    }
}