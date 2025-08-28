<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'activity_date',
        'startup_id',
        'user_id',
        'product_id',
        'type',
        'missed_verification_state',
        'status',
        'fe_front',
        'fe_middle',
        'fe_back',
        'non_fe_front',
        'non_fe_middle',
        'non_fe_back',
        'ss_front',
        'ss_middle',
        'ss_back',
        'wor',
        'foreman_id',
        'remarks',
    ];

    protected $casts = [
        'activity_date' => 'datetime:Y-m-d H:i:s',
    ];  

    protected $appends = ['shift'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function foreman() {
        return $this->belongsTo(User::class, 'foreman_id');
    }

    public function startup() {
        return $this->belongsTo(Startup::class);
    }   

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function getShiftAttribute() {
        return Shift::getShiftByDatetime($this->attributes['activity_date'])?->name ?? 'N/A';
    }
}
