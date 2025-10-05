<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Vendor;
use App\Models\DemandTracking;
use App\Services\DynamicPricingService;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateDemandTracking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamic-pricing:update-demand-tracking {--hours=1 : Number of hours to look back}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update demand tracking data for dynamic pricing algorithm';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting demand tracking update...');
        
        $hours = $this->option('hours');
        $startTime = Carbon::now()->subHours($hours);
        
        try {
            // Get all vendors
            $vendors = Vendor::where('is_active', true)->get();
            
            $this->info("Processing {$vendors->count()} vendors...");
            
            foreach ($vendors as $vendor) {
                $this->updateVendorDemandTracking($vendor, $startTime);
            }
            
            $this->info('Demand tracking update completed successfully!');
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Error updating demand tracking: ' . $e->getMessage());
            Log::error('Demand tracking update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }

    /**
     * Update demand tracking for a specific vendor
     */
    private function updateVendorDemandTracking($vendor, $startTime)
    {
        $this->line("Processing vendor: {$vendor->name} (ID: {$vendor->id})");
        
        // Process different service types
        $serviceTypes = ['delivery', 'package', 'taxi'];
        
        foreach ($serviceTypes as $serviceType) {
            $this->updateServiceTypeDemandTracking($vendor, $serviceType, $startTime);
        }
    }

    /**
     * Update demand tracking for a specific service type
     */
    private function updateServiceTypeDemandTracking($vendor, $serviceType, $startTime)
    {
        // Get orders for this vendor and service type in the time period
        $orders = $this->getOrdersForVendor($vendor->id, $serviceType, $startTime);
        
        if ($orders->isEmpty()) {
            return;
        }
        
        // Group orders by location and hour
        $locationHourGroups = $this->groupOrdersByLocationAndHour($orders);
        
        foreach ($locationHourGroups as $group) {
            $this->updateLocationHourDemandTracking($vendor->id, $serviceType, $group);
        }
    }

    /**
     * Get orders for a vendor and service type
     */
    private function getOrdersForVendor($vendorId, $serviceType, $startTime)
    {
        $query = Order::where('vendor_id', $vendorId)
                     ->where('created_at', '>=', $startTime)
                     ->whereIn('status', ['pending', 'preparing', 'ready', 'enroute']);
        
        // Filter by service type based on order characteristics
        if ($serviceType === 'package') {
            $query->whereNotNull('package_type_id');
        } elseif ($serviceType === 'taxi') {
            $query->whereHas('taxi_order');
        } else {
            // Regular delivery
            $query->whereNull('package_type_id')
                  ->whereDoesntHave('taxi_order');
        }
        
        return $query->get();
    }

    /**
     * Group orders by location and hour
     */
    private function groupOrdersByLocationAndHour($orders)
    {
        $groups = [];
        
        foreach ($orders as $order) {
            $latitude = $order->delivery_address->latitude ?? $order->vendor->latitude;
            $longitude = $order->delivery_address->longitude ?? $order->vendor->longitude;
            $hour = $order->created_at->hour;
            $date = $order->created_at->toDateString();
            
            $key = "{$latitude}_{$longitude}_{$date}_{$hour}";
            
            if (!isset($groups[$key])) {
                $groups[$key] = [
                    'latitude' => round($latitude, 4),
                    'longitude' => round($longitude, 4),
                    'date' => $date,
                    'hour' => $hour,
                    'orders' => []
                ];
            }
            
            $groups[$key]['orders'][] = $order;
        }
        
        return $groups;
    }

    /**
     * Update demand tracking for a specific location and hour
     */
    private function updateLocationHourDemandTracking($vendorId, $serviceType, $group)
    {
        $ordersCount = count($group['orders']);
        $pendingOrders = collect($group['orders'])->where('status', 'pending')->count();
        
        // Get available drivers count (placeholder - implement based on your system)
        $availableDrivers = $this->getAvailableDriversCount($vendorId, $group['latitude'], $group['longitude']);
        
        // Calculate metrics
        $demandSupplyRatio = $availableDrivers > 0 ? $ordersCount / $availableDrivers : $ordersCount;
        $demandLevel = $this->calculateDemandLevel($demandSupplyRatio);
        $recommendedMultiplier = $this->calculateRecommendedMultiplier($demandLevel);
        
        // Update or create demand tracking record
        DemandTracking::updateOrCreate(
            [
                'vendor_id' => $vendorId,
                'service_type' => $serviceType,
                'latitude' => $group['latitude'],
                'longitude' => $group['longitude'],
                'tracking_date' => $group['date'],
                'hour_of_day' => $group['hour']
            ],
            [
                'orders_count' => $ordersCount,
                'pending_orders' => $pendingOrders,
                'active_drivers' => $availableDrivers,
                'available_drivers' => $availableDrivers,
                'average_wait_time' => 0, // Placeholder
                'average_delivery_time' => 0, // Placeholder
                'demand_supply_ratio' => $demandSupplyRatio,
                'demand_level' => $demandLevel,
                'recommended_multiplier' => $recommendedMultiplier,
                'weather_condition' => 'clear', // Placeholder
                'is_holiday' => false, // Placeholder
                'is_weekend' => Carbon::parse($group['date'])->isWeekend(),
                'special_event' => null, // Placeholder
                'tracking_time' => Carbon::parse($group['date'])->setHour($group['hour'])->format('H:i:s'),
                'area_code' => $this->getAreaCode($group['latitude'], $group['longitude'])
            ]
        );
    }

    /**
     * Get available drivers count (placeholder)
     */
    private function getAvailableDriversCount($vendorId, $latitude, $longitude)
    {
        // This is a placeholder - implement based on your driver tracking system
        // You might query your driver locations table or use a real-time tracking service
        return rand(5, 20);
    }

    /**
     * Calculate demand level based on ratio
     */
    private function calculateDemandLevel($ratio)
    {
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
     * Calculate recommended multiplier based on demand level
     */
    private function calculateRecommendedMultiplier($demandLevel)
    {
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
     * Get area code for location (placeholder)
     */
    private function getAreaCode($latitude, $longitude)
    {
        return 'AREA_' . round($latitude, 2) . '_' . round($longitude, 2);
    }
}
