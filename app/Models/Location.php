<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $fillable = [
        'building_id',
        'flat_id',
        'country',
        'country_flag',
        'city',
        'zone'
    ];
}
