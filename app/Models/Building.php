<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{

    protected $fillable = [
        'name',
        'code',
        'zone_id',
        'city_id',
        'country_id'
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function user(){
        return $this->hasMany(User::class);
    }
}
