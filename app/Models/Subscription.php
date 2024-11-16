<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{


    protected $fillable = [
        'user_id',
        'plan_id',
        'start_date',
        'end_date',
        'status',
        'sub_price',
        'country_id',
        'city_id',
        'zone_id',
        'building_id'
    ];

    public function plan(){
        return $this->belongsTo(Plan::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function zone(){
        return $this->belongsTo(Zone::class);
    }

    public function building(){
        return $this->belongsTo(Building::class);
    }
}
