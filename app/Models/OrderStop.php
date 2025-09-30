<?php

namespace App\Models;


use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Fluent;

class OrderStop extends BaseModel
{

    protected $appends = ['delivery_address', 'proof', 'attachments'];

    public function getDeliveryAddressAttribute()
    {
        // If there's a related delivery_address loaded or exists in DB
        if ($this->stop_id && $this->getRelationValue('delivery_address')) {
            return $this->getRelationValue('delivery_address');
        }

        // Fallback to inline address stored directly on the order_stops table
        return new Fluent([
            'id' => 0,
            'name'   => $this->address,
            'address'   => $this->address,
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
            'city'      => $this->city,
            'state'     => $this->state,
            'country'   => $this->country,
        ]);
    }

    public function delivery_address()
    {
        return $this->belongsTo('App\Models\DeliveryAddress', 'stop_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }

    public function getProofAttribute()
    {
        return $this->getFirstMediaUrl('proof');
    }

    //MEDIA
    public function getAttachmentsAttribute()
    {
        $mediaFiles = Media::where("model_id", $this->id)->where("model_type", "App\Models\OrderStop")->get();
        $links = $mediaFiles->map(function ($media, $key) {
            return [
                "link" => $media->getFullUrl(),
                "collection_name" => $media->collection_name,
            ];
        });
        return $links;
    }
}
