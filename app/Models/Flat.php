<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    protected $fillable=[
        'flat_number',
        'code',
        'building_id',
        'zone_id',
        'city_id',
        'country_id'
    ];
}
