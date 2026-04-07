<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journey extends Model
{
    use SoftDeletes;

    public function items()
    {
        return $this->hasMany('App\Models\JourneyItem');
    }
}
