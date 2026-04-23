<?php

namespace Webkul\EnhancedWishlistCompare\Listeners;

use Illuminate\Support\Facades\Auth;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\Customer\Repositories\CompareItemRepository;
use Webkul\EnhancedWishlistCompare\Repositories\EnhancedWishlistCompareCountRepository;

class CompareEventListener
{
    public function __construct(
        protected WishlistRepository $wishlistRepository,
        protected CompareItemRepository $compareItemRepository,
        protected EnhancedWishlistCompareCountRepository $enhancedWishlistCompareCountRepository
    ){}

    public function sync($eventPayload = null): void
    {
        $customerId = $this->resolveCustomerId($eventPayload);

        if (! $customerId) {
            return;
        }

        $wishlistCount = $this->wishlistRepository->where([
            'customer_id' => $customerId,
        ])->count();

        $compareCount = $this->compareItemRepository->where([
            'customer_id' => $customerId,
        ])->count();

        $this->enhancedWishlistCompareCountRepository->updateOrCreate(
            ['customer_id' => $customerId],
            [
                'wishlist_count' => $wishlistCount,
                'compare_count'  => $compareCount,
            ]
        );
    }

    protected function resolveCustomerId($eventPayload): ?int
    {
        if (is_object($eventPayload) && isset($eventPayload->customer_id)) {
            return (int) $eventPayload->customer_id;
        }

        if (is_numeric($eventPayload)) {
            $wishlistItem = $this->wishlistRepository->find((int) $eventPayload);
            $wishlistCustomerId = $wishlistItem ? $wishlistItem->customer_id : null;

            if ($wishlistCustomerId) {
                return (int) $wishlistCustomerId;
            }
        }

        return Auth::guard('customer')->id();
    }
}