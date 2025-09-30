<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Support\Facades\Auth;
use Kirschbaum\PowerJoins\PowerJoins;

class FoodRescue extends BaseModel
{
    use PowerJoins;
    use HasTranslations;

    public $translatable = ['title', 'description', 'pickup_instructions'];

    protected $fillable = [
        'title',
        'description',
        'original_price',
        'rescue_price',
        'available_quantity',
        'total_quantity',
        'available_from',
        'available_until',
        'vendor_id',
        'is_active',
        'pickup_instructions',
        'tags',
    ];

    protected $appends = [
        'formatted_date',
        'photo',
        'photos',
        'discount_percentage',
        'is_available',
        'time_remaining',
        'is_favourite'
    ];

    protected $with = ['vendor'];

    protected $casts = [
        'original_price' => 'decimal:2',
        'rescue_price' => 'decimal:2',
        'available_from' => 'datetime',
        'available_until' => 'datetime',
        'tags' => 'array',
        'is_active' => 'boolean',
    ];

    // SCOPES
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->whereHas('vendor', function ($q) {
                $q->where('is_active', 1);
            });
    }

    public function scopeAvailable($query)
    {
        return $query->active()
            ->where('available_quantity', '>', 0)
            ->where(function ($q) {
                $q->whereNull('available_from')
                    ->orWhere('available_from', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('available_until')
                    ->orWhere('available_until', '>=', now());
            });
    }

    public function scopeMine($query)
    {
        return $query->when(Auth::user()->hasRole('manager'), function ($query) {
            return $query->where('vendor_id', Auth::user()->vendor_id);
        })->when(Auth::user()->hasRole('city-admin'), function ($query) {
            return $query->whereHas('vendor', function ($query) {
                return $query->where('creator_id', Auth::id());
            });
        });
    }

    public function scopeNearby($query, $latitude, $longitude, $radius = 10)
    {
        return $query->whereHas('vendor', function ($q) use ($latitude, $longitude, $radius) {
            $q->selectRaw("*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$latitude, $longitude, $latitude])
                ->having('distance', '<', $radius)
                ->orderBy('distance');
        });
    }

    // RELATIONSHIPS
    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id', 'id')->withTrashed();
    }

    public function favourite()
    {
        return $this->belongsTo('App\Models\Favourite', 'id', 'food_rescue_id')
            ->where('user_id', auth('sanctum')->user()->id ?? 0);
    }

    public function orders()
    {
        return $this->hasMany('App\Models\OrderProduct', 'food_rescue_id', 'id');
    }

    // ATTRIBUTE ACCESSORS
    public function getDiscountPercentageAttribute()
    {
        if ($this->original_price > 0) {
            return round((($this->original_price - $this->rescue_price) / $this->original_price) * 100);
        }
        return 0;
    }

    public function getIsAvailableAttribute()
    {
        if (!$this->is_active || $this->available_quantity <= 0) {
            return false;
        }

        $now = now();
        
        if ($this->available_from && $this->available_from > $now) {
            return false;
        }

        if ($this->available_until && $this->available_until < $now) {
            return false;
        }

        return true;
    }

    public function getTimeRemainingAttribute()
    {
        if (!$this->available_until) {
            return null;
        }

        $now = now();
        if ($this->available_until <= $now) {
            return 'expired';
        }

        $diff = $now->diff($this->available_until);
        
        if ($diff->days > 0) {
            return $diff->days . ' day' . ($diff->days > 1 ? 's' : '') . ' remaining';
        } elseif ($diff->h > 0) {
            return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' remaining';
        } else {
            return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' remaining';
        }
    }

    public function getIsFavouriteAttribute()
    {
        if (auth('sanctum')->user()) {
            return $this->favourite ? true : false;
        } else {
            return false;
        }
    }

    public function getPhotosAttribute()
    {
        $mediaItems = $this->getMedia('default');
        $photos = [];

        foreach ($mediaItems as $mediaItem) {
            array_push($photos, $mediaItem->getFullUrl());
        }
        return $photos;
    }

    // METHODS
    public function decreaseQuantity($quantity = 1)
    {
        if ($this->available_quantity >= $quantity) {
            $this->available_quantity -= $quantity;
            $this->save();
            return true;
        }
        return false;
    }

    public function increaseQuantity($quantity = 1)
    {
        $this->available_quantity += $quantity;
        $this->save();
        return true;
    }

    public function isExpired()
    {
        return $this->available_until && $this->available_until < now();
    }

    public function markAsInactive()
    {
        $this->is_active = false;
        $this->save();
    }
}
