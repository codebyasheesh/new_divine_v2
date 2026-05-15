<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblReservation extends Model
{
    public function TblTimeSlot()
    {
        return $this->belongsTo(TblTimeSlot::class, 'timeslot_id');
    }

    public function oldcustomer()
    {
        return $this->belongsTo(OldCustomer::class, 'old_customer_id');
    }
}
