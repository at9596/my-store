<?php

namespace Webkul\EnhancedWishlistCompare\Http\Controllers;

use Illuminate\Support\Facades\Event;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\Customer\Repositories\CompareItemRepository;
use Webkul\EnhancedWishlistCompare\Repositories\EnhancedWishlistCompareCountRepository;

class EnhancedController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Customer\Repositories\WishlistRepository  $wishlistRepository
     * @param  \Webkul\Customer\Repositories\CompareItemRepository  $compareItemRepository
     * @param  \Webkul\EnhancedWishlistCompare\Repositories\EnhancedWishlistCompareCountRepository  $enhancedWishlistCompareCountRepository
     * @return void
     */
    public function __construct(
        protected WishlistRepository $wishlistRepository,
        protected CompareItemRepository $compareItemRepository,
        protected EnhancedWishlistCompareCountRepository $enhancedWishlistCompareCountRepository
    ) {
    }

    /**
     * Get wishlist count.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function wishlistCount()
    {
        $customer = auth()->guard('customer')->user();

        if (! $customer) {
            return response()->json(['count' => 0]);
        }

        $count = $this->wishlistRepository->count([
            'customer_id' => $customer->id,
        ]);

        $this->enhancedWishlistCompareCountRepository->updateOrCreate(
            ['customer_id' => $customer->id],
            ['wishlist_count' => $count]
        );

        return response()->json([
            'count' => $count
        ]);
    }

    /**
     * Get compare count.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function compareCount()
    {
        $customer = auth()->guard('customer')->user();

        if (! $customer) {
            return response()->json(['count' => 0]);
        }

        $count = $this->compareItemRepository->count([
            'customer_id' => $customer->id,
        ]);

        $this->enhancedWishlistCompareCountRepository->updateOrCreate(
            ['customer_id' => $customer->id],
            ['compare_count' => $count]
        );

        return response()->json([
            'count' => $count
        ]);
    }
}