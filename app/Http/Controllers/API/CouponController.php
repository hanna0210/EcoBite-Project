<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function index(Request $request)
    {
        $vendorTypeId = $request->vendor_type_id;
        $userId = auth('api')->id();

        $query = Coupon::with(['vendors', 'products', 'vendor_type'])
            ->active()
            ->validForUser($userId);

        // Filter by location if provided
        if ($request->latitude && $request->longitude) {
            $query->where(function ($query) use ($request) {
                return $query->whereHas('vendors', function ($query) use ($request) {
                    return $query->active()->within($request->latitude, $request->longitude);
                })->orWhereHas('vendors', function ($query) use ($request) {
                    return $query->active()->withinrange($request->latitude, $request->longitude);
                });
            });
        }

        // Filter by vendor type
        if ($vendorTypeId) {
            $query->where('vendor_type_id', $vendorTypeId);
        }

        return $request->page ? $query->paginate() : $query->get();
    }

    public function details(Request $request, $id)
    {
        $coupon = Coupon::with(['products', 'vendors', 'vendor_type'])
            ->whereId($id)
            ->active()
            ->first();

        if (!$coupon) {
            return response()->json([
                "message" => __("No Coupon Found")
            ], 404);
        }

        return response()->json($coupon, 200);
    }

    public function show(Request $request, $code)
    {
        $result = $this->couponService->getCouponDetails(
            $code,
            auth('api')->id()
        );

        if (!$result['success']) {
            return response()->json([
                "message" => $result['message']
            ], 400);
        }

        return response()->json($result['coupon'], 200);
    }

    public function validate(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'order_amount' => 'required|numeric|min:0',
            'vendor_id' => 'nullable|integer|exists:vendors,id',
            'vendor_type_id' => 'nullable|integer|exists:vendor_types,id',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'integer|exists:products,id',
        ]);

        $result = $this->couponService->validateAndApplyCoupon(
            $request->coupon_code,
            $request->order_amount,
            $request->vendor_id,
            $request->vendor_type_id,
            $request->product_ids ?? [],
            auth('api')->id()
        );

        $statusCode = $result['success'] ? 200 : 400;

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
            'discount' => $result['discount'],
            'coupon' => $result['coupon']
        ], $statusCode);
    }

    public function userStats(Request $request)
    {
        $stats = $this->couponService->getUserCouponStats(auth('api')->id());

        return response()->json([
            'success' => true,
            'data' => $stats
        ], 200);
    }
}
