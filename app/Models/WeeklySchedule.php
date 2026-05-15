<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklySchedule extends Model
{
    protected $fillable = [
        'day_of_week',
        'is_closed',
        'start_time',
        'end_time',
        'lunch_start',
        'lunch_end'
    ];
}
