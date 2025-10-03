<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CouponService
{
    /**
     * Validate and apply a coupon for an order
     *
     * @param string $couponCode
     * @param float $orderAmount
     * @param int|null $vendorId
     * @param int|null $vendorTypeId
     * @param array $productIds
     * @param int|null $userId
     * @return array
     */
    public function validateAndApplyCoupon(
        string $couponCode,
        float $orderAmount,
        ?int $vendorId = null,
        ?int $vendorTypeId = null,
        array $productIds = [],
        ?int $userId = null
    ): array {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) {
            return [
                'success' => false,
                'message' => __('User authentication required'),
                'discount' => 0,
                'coupon' => null
            ];
        }

        try {
            // Find the coupon with eager loading
            $coupon = Coupon::with(['vendors', 'products', 'vendor_type'])
                ->where('code', $couponCode)
                ->active()
                ->first();

            if (!$coupon) {
                return [
                    'success' => false,
                    'message' => __('Coupon code is invalid'),
                    'discount' => 0,
                    'coupon' => null
                ];
            }

            // Validate coupon usage
            $validationResult = $this->validateCouponUsage($coupon, $userId, $vendorId, $vendorTypeId, $productIds);
            
            if (!$validationResult['success']) {
                return $validationResult;
            }

            // Calculate discount
            $discount = $coupon->calculateDiscount($orderAmount);

            return [
                'success' => true,
                'message' => __('Coupon applied successfully'),
                'discount' => $discount,
                'coupon' => $coupon
            ];

        } catch (\Exception $e) {
            Log::error('Coupon validation error', [
                'coupon_code' => $couponCode,
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => __('An error occurred while validating the coupon'),
                'discount' => 0,
                'coupon' => null
            ];
        }
    }

    /**
     * Validate coupon usage for a specific user and context
     *
     * @param Coupon $coupon
     * @param int $userId
     * @param int|null $vendorId
     * @param int|null $vendorTypeId
     * @param array $productIds
     * @return array
     */
    public function validateCouponUsage(
        Coupon $coupon,
        int $userId,
        ?int $vendorId = null,
        ?int $vendorTypeId = null,
        array $productIds = []
    ): array {
        // Check if user can use this coupon
        if (!$coupon->canBeUsedByUser($userId)) {
            return [
                'success' => false,
                'message' => __('You cannot use this coupon'),
                'discount' => 0,
                'coupon' => null
            ];
        }

        // Check vendor type restriction
        if ($vendorTypeId && !$coupon->isValidForVendorType($vendorTypeId)) {
            return [
                'success' => false,
                'message' => __('Coupon code is invalid for this vendor type'),
                'discount' => 0,
                'coupon' => null
            ];
        }

        // Check vendor restriction
        if ($vendorId && !$coupon->isValidForVendor($vendorId)) {
            return [
                'success' => false,
                'message' => __('Coupon code is invalid for this vendor'),
                'discount' => 0,
                'coupon' => null
            ];
        }

        // Check product restriction
        if (!empty($productIds) && !$coupon->isValidForProducts($productIds)) {
            return [
                'success' => false,
                'message' => __('Coupon code is invalid for selected products'),
                'discount' => 0,
                'coupon' => null
            ];
        }

        // Check if user is new (for new users only coupons)
        if ($coupon->for_new_users_only) {
            $user = User::find($userId);
            if (!$user || $user->created_at->diffInDays(now()) > 30) {
                return [
                    'success' => false,
                    'message' => __('This coupon is only for new users'),
                    'discount' => 0,
                    'coupon' => null
                ];
            }
        }

        return [
            'success' => true,
            'message' => __('Coupon is valid'),
            'discount' => 0,
            'coupon' => $coupon
        ];
    }

    /**
     * Record coupon usage with database transaction for race condition prevention
     *
     * @param Coupon $coupon
     * @param int $userId
     * @param int|null $orderId
     * @return CouponUser|null
     */
    public function recordCouponUsage(Coupon $coupon, int $userId, ?int $orderId = null): ?CouponUser
    {
        try {
            return DB::transaction(function () use ($coupon, $userId, $orderId) {
                // Double-check usage limits within transaction
                if (!$coupon->canBeUsedByUser($userId)) {
                    throw new \Exception('Coupon usage limit exceeded');
                }

                // Record the usage
                return $coupon->recordUsage($userId, $orderId);
            });
        } catch (\Exception $e) {
            Log::error('Failed to record coupon usage', [
                'coupon_id' => $coupon->id,
                'user_id' => $userId,
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Get coupon details for display
     *
     * @param string $couponCode
     * @param int|null $userId
     * @return array
     */
    public function getCouponDetails(string $couponCode, ?int $userId = null): array
    {
        $userId = $userId ?? Auth::id();

        try {
            $coupon = Coupon::with(['vendors', 'products', 'vendor_type'])
                ->where('code', $couponCode)
                ->active()
                ->first();

            if (!$coupon) {
                return [
                    'success' => false,
                    'message' => __('No Coupon Found'),
                    'coupon' => null
                ];
            }

            // Check if user can use this coupon
            if ($userId && !$coupon->canBeUsedByUser($userId)) {
                return [
                    'success' => false,
                    'message' => __('You cannot use this coupon'),
                    'coupon' => null
                ];
            }

            return [
                'success' => true,
                'message' => __('Coupon found'),
                'coupon' => $coupon
            ];

        } catch (\Exception $e) {
            Log::error('Error getting coupon details', [
                'coupon_code' => $couponCode,
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => __('An error occurred while retrieving coupon details'),
                'coupon' => null
            ];
        }
    }

    /**
     * Get user's coupon usage statistics
     *
     * @param int|null $userId
     * @return array
     */
    public function getUserCouponStats(?int $userId = null): array
    {
        $userId = $userId ?? Auth::id();

        if (!$userId) {
            return [];
        }

        return CouponUser::where('user_id', $userId)
            ->with('coupon')
            ->get()
            ->groupBy('coupon_id')
            ->map(function ($usages) {
                $coupon = $usages->first()->coupon;
                return [
                    'coupon' => $coupon,
                    'usage_count' => $usages->count(),
                    'last_used' => $usages->max('created_at'),
                ];
            })
            ->values()
            ->toArray();
    }
}
