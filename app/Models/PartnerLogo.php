<?php

namespace App\Models;

class PartnerLogo extends BaseModel
{

    protected $appends = ['formatted_date', 'photo'];
    protected $fillable = ['name', 'is_active', 'in_order'];

    // Scope for active logos
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}

