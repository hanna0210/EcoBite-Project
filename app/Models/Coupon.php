<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\HasTranslations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends BaseModel
{
    use HasTranslations;
    
    public $translatable = ["description"];
    protected $appends = ['formatted_expires_on', 'use_left', 'expired', 'photo'];

    protected $fillable = [
        'code',
        'color',
        'description',
        'discount',
        'min_order_amount',
        'max_coupon_amount',
        'percentage',
        'expires_on',
        'times',
        'is_active',
        'for_delivery',
        'for_new_users_only',
        'for_zero_waste_module',
        'usage_instructions',
        'max_uses_per_user',
        'creator_id',
        'vendor_type_id',
    ];

    protected $casts = [
        'for_delivery' => 'boolean',
        'for_new_users_only' => 'boolean',
        'for_zero_waste_module' => 'boolean',
        'percentage' => 'boolean',
        'is_active' => 'boolean',
        'discount' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_coupon_amount' => 'decimal:2',
        'expires_on' => 'date',
        'times' => 'integer',
        'max_uses_per_user' => 'integer',
    ];

    // Relationships
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function vendors(): BelongsToMany
    {
        return $this->belongsToMany(Vendor::class);
    }

    public function vendor_type(): BelongsTo
    {
        return $this->belongsTo(VendorType::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function coupon_users(): HasMany
    {
        return $this->hasMany(CouponUser::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('expires_on', '>', now());
    }

    public function scopeValidForUser($query, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        return $query->where(function ($q) use ($userId) {
            $q->where('for_new_users_only', false)
              ->orWhere(function ($subQ) use ($userId) {
                  $subQ->where('for_new_users_only', true)
                       ->whereDoesntHave('coupon_users', function ($userQ) use ($userId) {
                           $userQ->where('user_id', $userId);
                       });
              });
        });
    }

    // Accessors
    public function getFormattedExpiresOnAttribute(): string
    {
        return $this->expires_on ? $this->expires_on->format('d M Y') : '';
    }

    public function getUseLeftAttribute(): int
    {
        if (empty($this->times)) {
            return 1;
        }

        $userId = Auth::id();
        if (!$userId) {
            return 0;
        }

        $couponUses = $this->coupon_users()
            ->where('user_id', $userId)
            ->count();

        return max(0, $this->times - $couponUses);
    }

    public function getExpiredAttribute(): bool
    {
        return $this->expires_on < now();
    }

    // Business Logic Methods
    public function canBeUsedByUser($userId = null): bool
    {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) {
            return false;
        }

        // Check if coupon is active and not expired
        if (!$this->is_active || $this->expires_on < now()) {
            return false;
        }

        // Check if user has exceeded global usage limit
        if ($this->times && $this->coupon_users()->count() >= $this->times) {
            return false;
        }

        // Check if user has exceeded per-user usage limit
        if ($this->max_uses_per_user) {
            $userUsageCount = $this->coupon_users()
                ->where('user_id', $userId)
                ->count();
            
            if ($userUsageCount >= $this->max_uses_per_user) {
                return false;
            }
        }

        // Check if coupon is for new users only
        if ($this->for_new_users_only) {
            $hasUsedBefore = $this->coupon_users()
                ->where('user_id', $userId)
                ->exists();
            
            if ($hasUsedBefore) {
                return false;
            }
        }

        return true;
    }

    public function calculateDiscount($orderAmount): float
    {
        if ($this->percentage) {
            $discount = ($this->discount / 100) * $orderAmount;
        } else {
            $discount = $this->discount;
        }

        // Apply maximum coupon amount limit
        if ($this->max_coupon_amount && $discount > $this->max_coupon_amount) {
            $discount = $this->max_coupon_amount;
        }

        // Check minimum order amount
        if ($this->min_order_amount && $orderAmount < $this->min_order_amount) {
            return 0;
        }

        return max(0, $discount);
    }

    public function isValidForVendor($vendorId): bool
    {
        // If no vendor restrictions, valid for all vendors
        if ($this->vendors()->count() === 0) {
            return true;
        }

        return $this->vendors()->where('vendors.id', $vendorId)->exists();
    }

    public function isValidForVendorType($vendorTypeId): bool
    {
        // If no vendor type restriction, valid for all vendor types
        if (!$this->vendor_type_id) {
            return true;
        }

        return $this->vendor_type_id === $vendorTypeId;
    }

    public function isValidForProducts(array $productIds): bool
    {
        // If no product restrictions, valid for all products
        if ($this->products()->count() === 0) {
            return true;
        }

        return $this->products()->whereIn('products.id', $productIds)->exists();
    }

    public function recordUsage($userId, $orderId = null): CouponUser
    {
        return $this->coupon_users()->create([
            'user_id' => $userId,
            'order_id' => $orderId,
        ]);
    }
}
