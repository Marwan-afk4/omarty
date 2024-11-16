<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'content',
        'subscription_type',
        'price_discount',
        'duration'
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}