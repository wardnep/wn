<?php

namespace App\Models\CVM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendToNotification extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
}
