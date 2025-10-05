<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DemandTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'service_type',
        'latitude',
        'longitude',
        'area_code',
        'tracking_date',
        'tracking_time',
        'hour_of_day',
        'orders_count',
        'pending_orders',
        'active_drivers',
        'available_drivers',
        'average_wait_time',
        'average_delivery_time',
        'demand_supply_ratio',
        'demand_level',
        'recommended_multiplier',
        'weather_condition',
        'is_holiday',
        'is_weekend',
        'special_event'
    ];

    protected $casts = [
        'latitude' => 'decimal:4',
        'longitude' => 'decimal:4',
        'tracking_date' => 'date',
        'tracking_time' => 'datetime:H:i:s',
        'hour_of_day' => 'integer',
        'orders_count' => 'integer',
        'pending_orders' => 'integer',
        'active_drivers' => 'integer',
        'available_drivers' => 'integer',
        'average_wait_time' => 'decimal:2',
        'average_delivery_time' => 'decimal:2',
        'demand_supply_ratio' => 'decimal:2',
        'demand_level' => 'integer',
        'recommended_multiplier' => 'decimal:2',
        'is_holiday' => 'boolean',
        'is_weekend' => 'boolean'
    ];

    /**
     * Relationships
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Scopes
     */
    public function scopeForVendor($query, $vendorId)
    {
        return $query->where('vendor_id', $vendorId);
    }

    public function scopeForServiceType($query, $serviceType)
    {
        return $query->where('service_type', $serviceType);
    }

    public function scopeForDate($query, $date)
    {
        return $query->where('tracking_date', $date);
    }

    public function scopeForHour($query, $hour)
    {
        return $query->where('hour_of_day', $hour);
    }

    public function scopeForLocation($query, $latitude, $longitude, $precision = 0.01)
    {
        return $query->whereBetween('latitude', [$latitude - $precision, $latitude + $precision])
                    ->whereBetween('longitude', [$longitude - $precision, $longitude + $precision]);
    }

    public function scopeForArea($query, $areaCode)
    {
        return $query->where('area_code', $areaCode);
    }

    public function scopeHighDemand($query)
    {
        return $query->where('demand_level', '>=', 2);
    }

    public function scopeRecent($query, $hours = 24)
    {
        $cutoff = Carbon::now()->subHours($hours);
        return $query->where('tracking_date', '>=', $cutoff->toDateString())
                    ->where(function ($q) use ($cutoff) {
                        $q->where('tracking_date', '>', $cutoff->toDateString())
                          ->orWhere(function ($q2) use ($cutoff) {
                              $q2->where('tracking_date', $cutoff->toDateString())
                                 ->where('hour_of_day', '>=', $cutoff->hour);
                          });
                    });
    }

    /**
     * Get current demand level for a location
     */
    public static function getCurrentDemandLevel($vendorId, $serviceType, $latitude, $longitude, $areaCode = null)
    {
        $query = static::forVendor($vendorId)
                      ->forServiceType($serviceType)
                      ->forDate(Carbon::now()->toDateString())
                      ->forHour(Carbon::now()->hour);

        if ($areaCode) {
            $query->forArea($areaCode);
        } else {
            $query->forLocation($latitude, $longitude);
        }

        $tracking = $query->first();
        
        return $tracking ? $tracking->demand_level : 0;
    }

    /**
     * Get recommended multiplier for a location
     */
    public static function getRecommendedMultiplier($vendorId, $serviceType, $latitude, $longitude, $areaCode = null)
    {
        $query = static::forVendor($vendorId)
                      ->forServiceType($serviceType)
                      ->forDate(Carbon::now()->toDateString())
                      ->forHour(Carbon::now()->hour);

        if ($areaCode) {
            $query->forArea($areaCode);
        } else {
            $query->forLocation($latitude, $longitude);
        }

        $tracking = $query->first();
        
        return $tracking ? $tracking->recommended_multiplier : 1.00;
    }

    /**
     * Update or create demand tracking record
     */
    public static function updateDemandTracking($data)
    {
        $latitude = round($data['latitude'], 4);
        $longitude = round($data['longitude'], 4);
        
        return static::updateOrCreate(
            [
                'vendor_id' => $data['vendor_id'],
                'service_type' => $data['service_type'],
                'latitude' => $latitude,
                'longitude' => $longitude,
                'tracking_date' => $data['tracking_date'],
                'hour_of_day' => $data['hour_of_day']
            ],
            $data
        );
    }

    /**
     * Calculate demand level based on metrics
     */
    public function calculateDemandLevel()
    {
        $ratio = $this->demand_supply_ratio;
        
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
    public function calculateRecommendedMultiplier()
    {
        $demandLevel = $this->demand_level;
        
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
     * Get demand trends for analytics
     */
    public static function getDemandTrends($vendorId = null, $serviceType = null, $days = 7)
    {
        $query = static::query();
        
        if ($vendorId) {
            $query->forVendor($vendorId);
        }
        
        if ($serviceType) {
            $query->forServiceType($serviceType);
        }
        
        $startDate = Carbon::now()->subDays($days)->toDateString();
        
        return $query->where('tracking_date', '>=', $startDate)
                    ->selectRaw('tracking_date, hour_of_day, AVG(demand_level) as avg_demand, AVG(recommended_multiplier) as avg_multiplier, SUM(orders_count) as total_orders')
                    ->groupBy('tracking_date', 'hour_of_day')
                    ->orderBy('tracking_date')
                    ->orderBy('hour_of_day')
                    ->get();
    }

    /**
     * Get peak hours analysis
     */
    public static function getPeakHoursAnalysis($vendorId = null, $serviceType = null, $days = 30)
    {
        $query = static::query();
        
        if ($vendorId) {
            $query->forVendor($vendorId);
        }
        
        if ($serviceType) {
            $query->forServiceType($serviceType);
        }
        
        $startDate = Carbon::now()->subDays($days)->toDateString();
        
        return $query->where('tracking_date', '>=', $startDate)
                    ->selectRaw('hour_of_day, AVG(demand_level) as avg_demand, AVG(recommended_multiplier) as avg_multiplier, SUM(orders_count) as total_orders, COUNT(*) as data_points')
                    ->groupBy('hour_of_day')
                    ->orderBy('avg_demand', 'desc')
                    ->get();
    }
}
