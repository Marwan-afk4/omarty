<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{


    protected $fillable = [
        'country_id',
        'city_id',
        'zone_id',
        'building_id',
        'flat_id',
        'apartment_name',
        'admin_id',
        'code'
    ];

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

    public function flat(){
        return $this->belongsTo(Flat::class);
    }

    public function admin(){
        return $this->belongsTo(User::class);
    }
}
