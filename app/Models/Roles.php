<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable =[
        'admin_position_id',
        'role_name',
    ];
}
