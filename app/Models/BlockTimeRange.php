<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockTimeRange extends Model
{
    protected $fillable = [
        'type',
        'day_of_week',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'is_full_day',
        'reason'
    ];
}
