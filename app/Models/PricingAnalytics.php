<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PricingAnalytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'vendor_id',
        'dynamic_pricing_rule_id',
        'base_price',
        'original_price',
        'dynamic_price',
        'multiplier_applied',
        'service_type',
        'latitude',
        'longitude',
        'order_time',
        'order_date',
        'demand_level',
        'supply_level',
        'weather_condition',
        'temperature',
        'is_holiday',
        'is_weekend',
        'special_event',
        'order_accepted',
        'accepted_at',
        'rejected_at',
        'rejection_reason'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'dynamic_price' => 'decimal:2',
        'multiplier_applied' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'order_time' => 'datetime:H:i:s',
        'order_date' => 'date',
        'demand_level' => 'integer',
        'supply_level' => 'integer',
        'temperature' => 'decimal:2',
        'is_holiday' => 'boolean',
        'is_weekend' => 'boolean',
        'order_accepted' => 'boolean',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime'
    ];

    /**
     * Relationships
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function dynamicPricingRule()
    {
        return $this->belongsTo(DynamicPricingRule::class);
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

    public function scopeForDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('order_date', [$startDate, $endDate]);
    }

    public function scopeAccepted($query)
    {
        return $query->where('order_accepted', true);
    }

    public function scopeRejected($query)
    {
        return $query->where('order_accepted', false);
    }

    public function scopePending($query)
    {
        return $query->whereNull('order_accepted');
    }

    /**
     * Calculate price increase percentage
     */
    public function getPriceIncreasePercentageAttribute()
    {
        if ($this->original_price <= 0) {
            return 0;
        }
        
        return round((($this->dynamic_price - $this->original_price) / $this->original_price) * 100, 2);
    }

    /**
     * Get conversion rate for a given period
     */
    public static function getConversionRate($vendorId = null, $startDate = null, $endDate = null)
    {
        $query = static::query();
        
        if ($vendorId) {
            $query->where('vendor_id', $vendorId);
        }
        
        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }
        
        $total = $query->count();
        $accepted = $query->where('order_accepted', true)->count();
        
        return $total > 0 ? round(($accepted / $total) * 100, 2) : 0;
    }

    /**
     * Get average multiplier for a given period
     */
    public static function getAverageMultiplier($vendorId = null, $startDate = null, $endDate = null)
    {
        $query = static::query();
        
        if ($vendorId) {
            $query->where('vendor_id', $vendorId);
        }
        
        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }
        
        return $query->avg('multiplier_applied') ?: 1.00;
    }

    /**
     * Get demand level distribution
     */
    public static function getDemandLevelDistribution($vendorId = null, $startDate = null, $endDate = null)
    {
        $query = static::query();
        
        if ($vendorId) {
            $query->where('vendor_id', $vendorId);
        }
        
        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }
        
        return $query->selectRaw('demand_level, COUNT(*) as count')
                    ->groupBy('demand_level')
                    ->orderBy('demand_level')
                    ->get();
    }

    /**
     * Get hourly demand patterns
     */
    public static function getHourlyDemandPatterns($vendorId = null, $startDate = null, $endDate = null)
    {
        $query = static::query();
        
        if ($vendorId) {
            $query->where('vendor_id', $vendorId);
        }
        
        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }
        
        return $query->selectRaw('HOUR(order_time) as hour, AVG(demand_level) as avg_demand, AVG(multiplier_applied) as avg_multiplier, COUNT(*) as order_count')
                    ->groupBy('hour')
                    ->orderBy('hour')
                    ->get();
    }

    /**
     * Mark order as accepted
     */
    public function markAsAccepted()
    {
        $this->update([
            'order_accepted' => true,
            'accepted_at' => now()
        ]);
    }

    /**
     * Mark order as rejected
     */
    public function markAsRejected($reason = null)
    {
        $this->update([
            'order_accepted' => false,
            'rejected_at' => now(),
            'rejection_reason' => $reason
        ]);
    }
}
