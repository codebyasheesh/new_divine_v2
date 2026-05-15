<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
