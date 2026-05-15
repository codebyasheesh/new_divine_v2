<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * This function is used to define the relationship between booking and customer table.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id')->withTrashed();
    }
}
