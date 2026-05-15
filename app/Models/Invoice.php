<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * This function is used to define the relationship between booking and customer table.
     */
    /*public function payment()
    {
        return $this->hasOne(Payment::class, 'invoice_id');
    }*/
    
    // Remove because customer table is not in use.
    /*public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }*/

    public function payment()
    {
        return $this->hasOne(Payment::class, 'invoice_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($invoice) {
            if ($invoice->isForceDeleting()) {
                // Permanent delete → permanently remove payment
                $invoice->payment()->withTrashed()->forceDelete();
            } else {
                // Soft delete → soft delete related payment
                $invoice->payment()->delete();
            }
        });

        static::restoring(function ($invoice) {
            // Restore invoice → restore its payment too
            $invoice->payment()->withTrashed()->restore();
        });
    }
}
