<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
    protected $fillable =[
        'user_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'status',
    ];

}
