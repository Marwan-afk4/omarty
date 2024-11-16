<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'image',
        'admin_position_id',
        'building_id',
        'flat_id',
        'user_code',
        'role',
        'city_id',
        'zone_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function building(){
        return $this->belongsTo(Building::class);
    }
}
