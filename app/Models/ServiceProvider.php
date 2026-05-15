<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceProvider extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'title',
        'license',
    ];
}
