<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportIssue extends Model
{
    protected $fillable =[
        'user_id',
        'message',
        'image',
        'date',
    ];

}
