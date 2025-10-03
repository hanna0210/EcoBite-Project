<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kirschbaum\PowerJoins\PowerJoins;

class CouponUser extends Model
{
    use HasFactory, PowerJoins;
    
    public $table = "coupon_user";
    public $timestamps = true;

    protected $fillable = [
        'coupon_id',
        'user_id',
        'order_id',
    ];

    protected $casts = [
        'coupon_id' => 'integer',
        'user_id' => 'integer',
        'order_id' => 'integer',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
