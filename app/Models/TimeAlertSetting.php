<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeAlertSetting extends Model
{
    public $timestamps = false;

    protected $fillable = ['enabled'];

    protected $casts = ['enabled' => 'boolean'];
}
