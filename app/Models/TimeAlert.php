<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeAlert extends Model
{
    protected $fillable = ['alert_time', 'end_time', 'message', 'active'];
}
