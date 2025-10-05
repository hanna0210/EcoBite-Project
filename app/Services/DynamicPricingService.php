<?php

namespace App\Services;

use App\Models\DynamicPricingRule;
use App\Models\DemandTracking;
use App\Models\PricingAnalytics;
use App\Models\Vendor;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DynamicPricingService
{
    /**
     * Calculate dynamic pricing for an order
     */
    public function calculateDynamicPrice($orderData)
    {
        try {
            $vendorId = $orderData['vendor_id'];
            $serviceType = $orderData['service_type'] ?? 'delivery';
            $basePrice = $orderData['base_price'];
            $distancePrice = $orderData['distance_price'] ?? 0;
            $timePrice = $orderData['time_price'] ?? 0;
            $latitude = $orderData['latitude'];
            $longitude = $orderData['longitude'];
            $orderId = $orderData['order_id'] ?? null;

            // Get current demand level
            $demandLevel = $this->getCurrentDemandLevel($vendorId, $serviceType, $latitude, $longitude);
            
            // Get applicable pricing rules
            $rules = $this->getApplicableRules($serviceType, [
                'demand_level' => $demandLevel,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'vendor_id' => $vendorId,
                'is_weekend' => Carbon::now()->isWeekend(),
                'is_holiday' => $this->isHoliday(),
                'weather_condition' => $this->getWeatherCondition($latitude, $longitude)
            ]);

            // Calculate multipliers
            $multipliers = $this->calculateMultipliers($rules, $demandLevel);
            
            // Apply multipliers to prices
            $dynamicPrices = $this->applyMultipliers($basePrice, $distancePrice, $timePrice, $multipliers);
            
            // Track analytics
            $this->trackPricingDecision($orderData, $dynamicPrices, $multipliers, $demandLevel, $rules->first());
            
            return [
                'success' => true,
                'original_price' => $basePrice + $distancePrice + $timePrice,
                'dynamic_price' => $dynamicPrices['total'],
                'base_price' => $dynamicPrices['base'],
                'distance_price' => $dynamicPrices['distance'],
                'time_price' => $dynamicPrices['time'],
                'multipliers' => $multipliers,
                'demand_level' => $demandLevel,
                'applied_rule' => $rules->first()?->name,
                'price_increase_percentage' => $this->calculatePriceIncreasePercentage(
                    $basePrice + $distancePrice + $timePrice,
                    $dynamicPrices['total']
                )
            ];

        } catch (\Exception $e) {
            Log::error('Dynamic pricing calculation failed', [
                'error' => $e->getMessage(),
                'order_data' => $orderData
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'original_price' => $basePrice + $distancePrice + $timePrice,
                'dynamic_price' => $basePrice + $distancePrice + $timePrice,
                'multipliers' => ['base' => 1.0, 'distance' => 1.0, 'time' => 1.0]
            ];
        }
    }

    /**
     * Get current demand level for a location
     */
    public function getCurrentDemandLevel($vendorId, $serviceType, $latitude, $longitude, $areaCode = null)
    {
        $cacheKey = "demand_level_{$vendorId}_{$serviceType}_" . round($latitude, 2) . "_" . round($longitude, 2);
        
        return Cache::remember($cacheKey, 300, function () use ($vendorId, $serviceType, $latitude, $longitude, $areaCode) {
            return DemandTracking::getCurrentDemandLevel($vendorId, $serviceType, $latitude, $longitude, $areaCode);
        });
    }

    /**
     * Get applicable pricing rules
     */
    public function getApplicableRules($serviceType, $conditions = [])
    {
        return DynamicPricingRule::getApplicableRules($serviceType, $conditions);
    }

    /**
     * Calculate multipliers based on rules and demand
     */
    public function calculateMultipliers($rules, $demandLevel)
    {
        $baseMultiplier = 1.0;
        $distanceMultiplier = 1.0;
        $timeMultiplier = 1.0;

        foreach ($rules as $rule) {
            $ruleMultiplier = $rule->calculateMultiplier($demandLevel);
            
            $baseMultiplier *= $rule->base_multiplier;
            $distanceMultiplier *= $rule->distance_multiplier;
            $timeMultiplier *= $rule->time_multiplier;
        }

        // Apply demand-based adjustments
        $demandMultiplier = $this->getDemandBasedMultiplier($demandLevel);
        $baseMultiplier *= $demandMultiplier;

        return [
            'base' => round($baseMultiplier, 2),
            'distance' => round($distanceMultiplier, 2),
            'time' => round($timeMultiplier, 2),
            'demand' => round($demandMultiplier, 2)
        ];
    }

    /**
     * Apply multipliers to prices
     */
    public function applyMultipliers($basePrice, $distancePrice, $timePrice, $multipliers)
    {
        $dynamicBasePrice = $basePrice * $multipliers['base'];
        $dynamicDistancePrice = $distancePrice * $multipliers['distance'];
        $dynamicTimePrice = $timePrice * $multipliers['time'];
        
        $totalPrice = $dynamicBasePrice + $dynamicDistancePrice + $dynamicTimePrice;

        return [
            'base' => round($dynamicBasePrice, 2),
            'distance' => round($dynamicDistancePrice, 2),
            'time' => round($dynamicTimePrice, 2),
            'total' => round($totalPrice, 2)
        ];
    }

    /**
     * Get demand-based multiplier
     */
    public function getDemandBasedMultiplier($demandLevel)
    {
        switch ($demandLevel) {
            case 3: // Critical demand
                return 2.5;
            case 2: // High demand
                return 1.8;
            case 1: // Medium demand
                return 1.3;
            default: // Low demand
                return 1.0;
        }
    }

    /**
     * Track pricing decision for analytics
     */
    public function trackPricingDecision($orderData, $dynamicPrices, $multipliers, $demandLevel, $appliedRule = null)
    {
        try {
            PricingAnalytics::create([
                'order_id' => $orderData['order_id'] ?? null,
                'vendor_id' => $orderData['vendor_id'],
                'dynamic_pricing_rule_id' => $appliedRule?->id,
                'base_price' => $orderData['base_price'],
                'original_price' => $orderData['base_price'] + ($orderData['distance_price'] ?? 0) + ($orderData['time_price'] ?? 0),
                'dynamic_price' => $dynamicPrices['total'],
                'multiplier_applied' => $multipliers['base'],
                'service_type' => $orderData['service_type'] ?? 'delivery',
                'latitude' => $orderData['latitude'],
                'longitude' => $orderData['longitude'],
                'order_time' => Carbon::now()->format('H:i:s'),
                'order_date' => Carbon::now()->toDateString(),
                'demand_level' => $demandLevel,
                'supply_level' => $this->getSupplyLevel($orderData['vendor_id'], $orderData['service_type'] ?? 'delivery'),
                'weather_condition' => $this->getWeatherCondition($orderData['latitude'], $orderData['longitude']),
                'is_holiday' => $this->isHoliday(),
                'is_weekend' => Carbon::now()->isWeekend(),
                'special_event' => $this->getSpecialEvent($orderData['latitude'], $orderData['longitude'])
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to track pricing decision', [
                'error' => $e->getMessage(),
                'order_data' => $orderData
            ]);
        }
    }

    /**
     * Update demand tracking
     */
    public function updateDemandTracking($vendorId, $serviceType, $latitude, $longitude, $orderCount = 1)
    {
        try {
            $now = Carbon::now();
            $areaCode = $this->getAreaCode($latitude, $longitude);
            
            // Get current tracking data
            $tracking = DemandTracking::forVendor($vendorId)
                ->forServiceType($serviceType)
                ->forDate($now->toDateString())
                ->forHour($now->hour)
                ->forLocation($latitude, $longitude)
                ->first();

            if ($tracking) {
                $tracking->update([
                    'orders_count' => $tracking->orders_count + $orderCount,
                    'pending_orders' => $tracking->pending_orders + $orderCount,
                    'demand_supply_ratio' => $this->calculateDemandSupplyRatio($tracking->orders_count + $orderCount, $tracking->available_drivers),
                    'demand_level' => $this->calculateDemandLevel($tracking->orders_count + $orderCount, $tracking->available_drivers),
                    'recommended_multiplier' => $this->calculateRecommendedMultiplier($tracking->orders_count + $orderCount, $tracking->available_drivers)
                ]);
            } else {
                // Create new tracking record
                $availableDrivers = $this->getAvailableDriversCount($vendorId, $latitude, $longitude);
                $ordersCount = $orderCount;
                
                DemandTracking::create([
                    'vendor_id' => $vendorId,
                    'service_type' => $serviceType,
                    'latitude' => round($latitude, 4),
                    'longitude' => round($longitude, 4),
                    'area_code' => $areaCode,
                    'tracking_date' => $now->toDateString(),
                    'tracking_time' => $now->format('H:i:s'),
                    'hour_of_day' => $now->hour,
                    'orders_count' => $ordersCount,
                    'pending_orders' => $ordersCount,
                    'active_drivers' => $availableDrivers,
                    'available_drivers' => $availableDrivers,
                    'average_wait_time' => 0,
                    'average_delivery_time' => 0,
                    'demand_supply_ratio' => $this->calculateDemandSupplyRatio($ordersCount, $availableDrivers),
                    'demand_level' => $this->calculateDemandLevel($ordersCount, $availableDrivers),
                    'recommended_multiplier' => $this->calculateRecommendedMultiplier($ordersCount, $availableDrivers),
                    'weather_condition' => $this->getWeatherCondition($latitude, $longitude),
                    'is_holiday' => $this->isHoliday(),
                    'is_weekend' => $now->isWeekend(),
                    'special_event' => $this->getSpecialEvent($latitude, $longitude)
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to update demand tracking', [
                'error' => $e->getMessage(),
                'vendor_id' => $vendorId,
                'service_type' => $serviceType,
                'latitude' => $latitude,
                'longitude' => $longitude
            ]);
        }
    }

    /**
     * Calculate demand-supply ratio
     */
    private function calculateDemandSupplyRatio($ordersCount, $availableDrivers)
    {
        if ($availableDrivers <= 0) {
            return $ordersCount > 0 ? 999.99 : 0;
        }
        
        return round($ordersCount / $availableDrivers, 2);
    }

    /**
     * Calculate demand level
     */
    private function calculateDemandLevel($ordersCount, $availableDrivers)
    {
        $ratio = $this->calculateDemandSupplyRatio($ordersCount, $availableDrivers);
        
        if ($ratio >= 3.0) {
            return 3; // Critical
        } elseif ($ratio >= 2.0) {
            return 2; // High
        } elseif ($ratio >= 1.0) {
            return 1; // Medium
        } else {
            return 0; // Low
        }
    }

    /**
     * Calculate recommended multiplier
     */
    private function calculateRecommendedMultiplier($ordersCount, $availableDrivers)
    {
        $demandLevel = $this->calculateDemandLevel($ordersCount, $availableDrivers);
        
        switch ($demandLevel) {
            case 3: // Critical
                return 2.5;
            case 2: // High
                return 1.8;
            case 1: // Medium
                return 1.3;
            default: // Low
                return 1.0;
        }
    }

    /**
     * Get available drivers count (placeholder - implement based on your driver tracking system)
     */
    private function getAvailableDriversCount($vendorId, $latitude, $longitude)
    {
        // This is a placeholder - implement based on your driver tracking system
        // You might query your driver locations table or use a real-time tracking service
        return rand(5, 20); // Placeholder random number
    }

    /**
     * Get supply level
     */
    private function getSupplyLevel($vendorId, $serviceType)
    {
        // Placeholder - implement based on your system
        return rand(5, 20);
    }

    /**
     * Get weather condition (placeholder - integrate with weather API)
     */
    private function getWeatherCondition($latitude, $longitude)
    {
        // Placeholder - integrate with weather API like OpenWeatherMap
        return 'clear'; // clear, rain, snow, storm, etc.
    }

    /**
     * Check if current date is a holiday
     */
    private function isHoliday()
    {
        // Placeholder - implement holiday checking logic
        return false;
    }

    /**
     * Get special events in the area
     */
    private function getSpecialEvent($latitude, $longitude)
    {
        // Placeholder - implement event detection logic
        return null;
    }

    /**
     * Get area code for location
     */
    private function getAreaCode($latitude, $longitude)
    {
        // Placeholder - implement area code logic based on coordinates
        return 'AREA_' . round($latitude, 2) . '_' . round($longitude, 2);
    }

    /**
     * Calculate price increase percentage
     */
    private function calculatePriceIncreasePercentage($originalPrice, $dynamicPrice)
    {
        if ($originalPrice <= 0) {
            return 0;
        }
        
        return round((($dynamicPrice - $originalPrice) / $originalPrice) * 100, 2);
    }

    /**
     * Get pricing analytics for a vendor
     */
    public function getPricingAnalytics($vendorId, $startDate = null, $endDate = null)
    {
        $startDate = $startDate ?: Carbon::now()->subDays(30)->toDateString();
        $endDate = $endDate ?: Carbon::now()->toDateString();

        return [
            'conversion_rate' => PricingAnalytics::getConversionRate($vendorId, $startDate, $endDate),
            'average_multiplier' => PricingAnalytics::getAverageMultiplier($vendorId, $startDate, $endDate),
            'demand_distribution' => PricingAnalytics::getDemandLevelDistribution($vendorId, $startDate, $endDate),
            'hourly_patterns' => PricingAnalytics::getHourlyDemandPatterns($vendorId, $startDate, $endDate),
            'peak_hours' => DemandTracking::getPeakHoursAnalysis($vendorId, null, 30)
        ];
    }
}
