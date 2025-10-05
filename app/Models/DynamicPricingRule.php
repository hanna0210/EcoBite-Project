<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class DynamicPricingRule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'service_type',
        'rule_type',
        'conditions',
        'start_time',
        'end_time',
        'days_of_week',
        'location_conditions',
        'base_multiplier',
        'distance_multiplier',
        'time_multiplier',
        'min_multiplier',
        'max_multiplier',
        'low_demand_threshold',
        'high_demand_threshold',
        'critical_demand_threshold',
        'is_active',
        'priority',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'conditions' => 'array',
        'days_of_week' => 'array',
        'location_conditions' => 'array',
        'base_multiplier' => 'decimal:2',
        'distance_multiplier' => 'decimal:2',
        'time_multiplier' => 'decimal:2',
        'min_multiplier' => 'decimal:2',
        'max_multiplier' => 'decimal:2',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    /**
     * Scope for active rules
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for rules that are currently valid (within date range)
     */
    public function scopeCurrentlyValid($query)
    {
        $now = Carbon::now();
        return $query->where(function ($q) use ($now) {
            $q->whereNull('start_date')
              ->orWhere('start_date', '<=', $now->toDateString());
        })->where(function ($q) use ($now) {
            $q->whereNull('end_date')
              ->orWhere('end_date', '>=', $now->toDateString());
        });
    }

    /**
     * Scope for time-based rules that match current time
     */
    public function scopeMatchingTime($query, $time = null)
    {
        $time = $time ?: Carbon::now();
        $currentTime = $time->format('H:i:s');
        $currentDay = $time->dayOfWeek; // 0 = Sunday, 1 = Monday, etc.

        return $query->where(function ($q) use ($currentTime, $currentDay) {
            // Time-based rules
            $q->where(function ($timeQuery) use ($currentTime) {
                $timeQuery->whereNull('start_time')
                         ->orWhere('start_time', '<=', $currentTime);
            })->where(function ($timeQuery) use ($currentTime) {
                $timeQuery->whereNull('end_time')
                         ->orWhere('end_time', '>=', $currentTime);
            });

            // Day-of-week rules
            $q->where(function ($dayQuery) use ($currentDay) {
                $dayQuery->whereNull('days_of_week')
                        ->orWhereJsonContains('days_of_week', $currentDay);
            });
        });
    }

    /**
     * Scope for service type
     */
    public function scopeForServiceType($query, $serviceType)
    {
        return $query->where('service_type', $serviceType);
    }

    /**
     * Scope for rule type
     */
    public function scopeOfType($query, $ruleType)
    {
        return $query->where('rule_type', $ruleType);
    }

    /**
     * Check if rule applies to given conditions
     */
    public function appliesTo($conditions = [])
    {
        // Check if rule is active and currently valid
        if (!$this->is_active || !$this->isCurrentlyValid()) {
            return false;
        }

        // Check time conditions
        if (!$this->matchesTimeConditions()) {
            return false;
        }

        // Check custom conditions
        if ($this->conditions && !$this->matchesCustomConditions($conditions)) {
            return false;
        }

        return true;
    }

    /**
     * Check if rule is currently valid based on date range
     */
    public function isCurrentlyValid()
    {
        $now = Carbon::now();
        
        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }
        
        if ($this->end_date && $now->gt($this->end_date)) {
            return false;
        }
        
        return true;
    }

    /**
     * Check if rule matches current time conditions
     */
    public function matchesTimeConditions($time = null)
    {
        $time = $time ?: Carbon::now();
        $currentTime = $time->format('H:i:s');
        $currentDay = $time->dayOfWeek;

        // Check time range
        if ($this->start_time && $this->end_time) {
            if ($this->start_time <= $this->end_time) {
                // Same day range (e.g., 09:00 to 17:00)
                if ($currentTime < $this->start_time || $currentTime > $this->end_time) {
                    return false;
                }
            } else {
                // Overnight range (e.g., 22:00 to 06:00)
                if ($currentTime < $this->start_time && $currentTime > $this->end_time) {
                    return false;
                }
            }
        }

        // Check days of week
        if ($this->days_of_week && !in_array($currentDay, $this->days_of_week)) {
            return false;
        }

        return true;
    }

    /**
     * Check if rule matches custom conditions
     */
    public function matchesCustomConditions($conditions)
    {
        if (!$this->conditions) {
            return true;
        }

        foreach ($this->conditions as $condition) {
            $field = $condition['field'] ?? null;
            $operator = $condition['operator'] ?? '=';
            $value = $condition['value'] ?? null;

            if (!$field || !isset($conditions[$field])) {
                continue;
            }

            $conditionValue = $conditions[$field];

            switch ($operator) {
                case '=':
                    if ($conditionValue != $value) return false;
                    break;
                case '!=':
                    if ($conditionValue == $value) return false;
                    break;
                case '>':
                    if ($conditionValue <= $value) return false;
                    break;
                case '>=':
                    if ($conditionValue < $value) return false;
                    break;
                case '<':
                    if ($conditionValue >= $value) return false;
                    break;
                case '<=':
                    if ($conditionValue > $value) return false;
                    break;
                case 'in':
                    if (!in_array($conditionValue, (array)$value)) return false;
                    break;
                case 'not_in':
                    if (in_array($conditionValue, (array)$value)) return false;
                    break;
            }
        }

        return true;
    }

    /**
     * Calculate multiplier based on demand level
     */
    public function calculateMultiplier($demandLevel = 0, $baseMultiplier = null)
    {
        $baseMultiplier = $baseMultiplier ?: $this->base_multiplier;
        
        // Apply demand-based adjustments
        $multiplier = $baseMultiplier;
        
        if ($demandLevel >= $this->critical_demand_threshold) {
            $multiplier = $this->max_multiplier;
        } elseif ($demandLevel >= $this->high_demand_threshold) {
            $multiplier = $baseMultiplier * 1.5;
        } elseif ($demandLevel >= $this->low_demand_threshold) {
            $multiplier = $baseMultiplier * 1.2;
        }

        // Ensure multiplier is within bounds
        $multiplier = max($this->min_multiplier, min($this->max_multiplier, $multiplier));

        return round($multiplier, 2);
    }

    /**
     * Get all applicable rules for given conditions
     */
    public static function getApplicableRules($serviceType, $conditions = [])
    {
        return static::active()
            ->currentlyValid()
            ->forServiceType($serviceType)
            ->matchingTime()
            ->orderBy('priority', 'desc')
            ->get()
            ->filter(function ($rule) use ($conditions) {
                return $rule->appliesTo($conditions);
            });
    }
}
