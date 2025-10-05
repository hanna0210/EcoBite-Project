<?php

namespace App\Traits;

use App\Services\DynamicPricingService;
use Illuminate\Support\Facades\Log;

trait DynamicPricingTrait
{
    /**
     * Apply dynamic pricing to delivery fee
     */
    public function applyDynamicPricingToDeliveryFee($vendorId, $baseDeliveryFee, $distanceFee, $latitude, $longitude, $serviceType = 'delivery')
    {
        try {
            $dynamicPricingService = app(DynamicPricingService::class);
            
            $orderData = [
                'vendor_id' => $vendorId,
                'service_type' => $serviceType,
                'base_price' => $baseDeliveryFee,
                'distance_price' => $distanceFee,
                'time_price' => 0,
                'latitude' => $latitude,
                'longitude' => $longitude
            ];

            $result = $dynamicPricingService->calculateDynamicPrice($orderData);
            
            if ($result['success']) {
                // Update demand tracking
                $dynamicPricingService->updateDemandTracking($vendorId, $serviceType, $latitude, $longitude);
                
                return [
                    'success' => true,
                    'original_delivery_fee' => $result['original_price'],
                    'dynamic_delivery_fee' => $result['dynamic_price'],
                    'base_delivery_fee' => $result['base_price'],
                    'distance_delivery_fee' => $result['distance_price'],
                    'multipliers' => $result['multipliers'],
                    'demand_level' => $result['demand_level'],
                    'applied_rule' => $result['applied_rule'],
                    'price_increase_percentage' => $result['price_increase_percentage']
                ];
            } else {
                Log::warning('Dynamic pricing failed, using original price', [
                    'error' => $result['error'],
                    'vendor_id' => $vendorId,
                    'original_price' => $result['original_price']
                ]);
                
                return [
                    'success' => false,
                    'original_delivery_fee' => $result['original_price'],
                    'dynamic_delivery_fee' => $result['original_price'],
                    'error' => $result['error']
                ];
            }
        } catch (\Exception $e) {
            Log::error('Dynamic pricing trait error', [
                'error' => $e->getMessage(),
                'vendor_id' => $vendorId,
                'base_delivery_fee' => $baseDeliveryFee,
                'distance_fee' => $distanceFee
            ]);
            
            return [
                'success' => false,
                'original_delivery_fee' => $baseDeliveryFee + $distanceFee,
                'dynamic_delivery_fee' => $baseDeliveryFee + $distanceFee,
                'error' => 'Dynamic pricing service unavailable'
            ];
        }
    }

    /**
     * Apply dynamic pricing to package delivery
     */
    public function applyDynamicPricingToPackageDelivery($vendorId, $basePrice, $distancePrice, $sizePrice, $latitude, $longitude, $orderId = null)
    {
        try {
            $dynamicPricingService = app(DynamicPricingService::class);
            
            $orderData = [
                'vendor_id' => $vendorId,
                'service_type' => 'package',
                'base_price' => $basePrice,
                'distance_price' => $distancePrice,
                'time_price' => $sizePrice, // Using time_price field for size price
                'latitude' => $latitude,
                'longitude' => $longitude,
                'order_id' => $orderId
            ];

            $result = $dynamicPricingService->calculateDynamicPrice($orderData);
            
            if ($result['success']) {
                // Update demand tracking
                $dynamicPricingService->updateDemandTracking($vendorId, 'package', $latitude, $longitude);
                
                return [
                    'success' => true,
                    'original_price' => $result['original_price'],
                    'dynamic_price' => $result['dynamic_price'],
                    'base_price' => $result['base_price'],
                    'distance_price' => $result['distance_price'],
                    'size_price' => $result['time_price'], // Map back to size price
                    'multipliers' => $result['multipliers'],
                    'demand_level' => $result['demand_level'],
                    'applied_rule' => $result['applied_rule'],
                    'price_increase_percentage' => $result['price_increase_percentage']
                ];
            } else {
                return [
                    'success' => false,
                    'original_price' => $result['original_price'],
                    'dynamic_price' => $result['original_price'],
                    'error' => $result['error']
                ];
            }
        } catch (\Exception $e) {
            Log::error('Dynamic pricing for package delivery failed', [
                'error' => $e->getMessage(),
                'vendor_id' => $vendorId,
                'base_price' => $basePrice,
                'distance_price' => $distancePrice,
                'size_price' => $sizePrice
            ]);
            
            return [
                'success' => false,
                'original_price' => $basePrice + $distancePrice + $sizePrice,
                'dynamic_price' => $basePrice + $distancePrice + $sizePrice,
                'error' => 'Dynamic pricing service unavailable'
            ];
        }
    }

    /**
     * Apply dynamic pricing to taxi fare
     */
    public function applyDynamicPricingToTaxiFare($vendorId, $baseFare, $distanceFare, $timeFare, $latitude, $longitude, $orderId = null)
    {
        try {
            $dynamicPricingService = app(DynamicPricingService::class);
            
            $orderData = [
                'vendor_id' => $vendorId,
                'service_type' => 'taxi',
                'base_price' => $baseFare,
                'distance_price' => $distanceFare,
                'time_price' => $timeFare,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'order_id' => $orderId
            ];

            $result = $dynamicPricingService->calculateDynamicPrice($orderData);
            
            if ($result['success']) {
                // Update demand tracking
                $dynamicPricingService->updateDemandTracking($vendorId, 'taxi', $latitude, $longitude);
                
                return [
                    'success' => true,
                    'original_fare' => $result['original_price'],
                    'dynamic_fare' => $result['dynamic_price'],
                    'base_fare' => $result['base_price'],
                    'distance_fare' => $result['distance_price'],
                    'time_fare' => $result['time_price'],
                    'multipliers' => $result['multipliers'],
                    'demand_level' => $result['demand_level'],
                    'applied_rule' => $result['applied_rule'],
                    'price_increase_percentage' => $result['price_increase_percentage']
                ];
            } else {
                return [
                    'success' => false,
                    'original_fare' => $result['original_price'],
                    'dynamic_fare' => $result['original_price'],
                    'error' => $result['error']
                ];
            }
        } catch (\Exception $e) {
            Log::error('Dynamic pricing for taxi fare failed', [
                'error' => $e->getMessage(),
                'vendor_id' => $vendorId,
                'base_fare' => $baseFare,
                'distance_fare' => $distanceFare,
                'time_fare' => $timeFare
            ]);
            
            return [
                'success' => false,
                'original_fare' => $baseFare + $distanceFare + $timeFare,
                'dynamic_fare' => $baseFare + $distanceFare + $timeFare,
                'error' => 'Dynamic pricing service unavailable'
            ];
        }
    }

    /**
     * Check if dynamic pricing is enabled for a vendor
     */
    public function isDynamicPricingEnabled($vendorId = null)
    {
        // Check global setting first
        $globalEnabled = setting('dynamic_pricing.enabled', false);
        
        if (!$globalEnabled) {
            return false;
        }
        
        // If vendor ID provided, check vendor-specific setting
        if ($vendorId) {
            $vendor = \App\Models\Vendor::find($vendorId);
            if ($vendor && isset($vendor->dynamic_pricing_enabled)) {
                return $vendor->dynamic_pricing_enabled;
            }
        }
        
        return $globalEnabled;
    }

    /**
     * Get dynamic pricing information for display
     */
    public function getDynamicPricingInfo($pricingResult)
    {
        if (!$pricingResult['success']) {
            return null;
        }
        
        $info = [
            'is_dynamic' => true,
            'demand_level' => $pricingResult['demand_level'],
            'applied_rule' => $pricingResult['applied_rule'],
            'price_increase_percentage' => $pricingResult['price_increase_percentage']
        ];
        
        // Add demand level description
        switch ($pricingResult['demand_level']) {
            case 3:
                $info['demand_description'] = 'Critical Demand';
                $info['demand_color'] = 'red';
                break;
            case 2:
                $info['demand_description'] = 'High Demand';
                $info['demand_color'] = 'orange';
                break;
            case 1:
                $info['demand_description'] = 'Medium Demand';
                $info['demand_color'] = 'yellow';
                break;
            default:
                $info['demand_description'] = 'Normal Demand';
                $info['demand_color'] = 'green';
        }
        
        return $info;
    }
}
