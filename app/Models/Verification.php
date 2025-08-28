<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'fe',
        'non_fe',
        'ss',
        'status',
        'foreman_id',
        'wor',
        'remarks'
    ];

    public function startup()
    {
        return $this->belongsTo(Startup::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }   

    public function foreman()
    {
        return $this->belongsTo(User::class, 'foreman_id');
    }
}
