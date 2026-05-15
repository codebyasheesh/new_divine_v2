<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function parent()
    {
        return $this->belongsTo(Customer::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Customer::class, 'parent_id', 'id');
    }

    // user Table Relation 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
