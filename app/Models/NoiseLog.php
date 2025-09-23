<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoiseLog extends Model
{
    protected $fillable = [
        'device_id',
        'startup_id',
        'log_time',
    ];
}
