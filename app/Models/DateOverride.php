<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateOverride extends Model
{
    protected $fillable = [
        'date',
        'is_closed',
        'custom_start_time',
        'custom_end_time'
    ];
}
