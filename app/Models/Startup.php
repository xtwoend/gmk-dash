<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Startup extends Model
{

    protected $fillable = [
        'device_id',
        'user_id',
        'startup_date',
        'verification_type',
        'status',
        'pause_reason',
        'pause_time'
    ];

    protected $appends = ['ng_count', 'ok_count', 'current_product'];

    public function verifications()
    {
        return $this->hasMany(Verification::class);
    }

    public function lastVerification()
    {
        return $this->hasOne(Verification::class)->latest();
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function currentActivity()
    {
        return $this->hasOne(Activity::class)->latest();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function getCurrentProductAttribute()
    {
        if ($this->status == 3) {
            return null;
        }
        
        return $this->products()->latest()->first();
    }

    public function records()
    {
        return $this->hasMany(Record::class, 'startup_id');
    }

    public function ngRecords()
    {
        return $this->hasMany(Record::class, 'startup_id')->where('status', 1);
    }

    protected function ngCount(): Attribute
    {
        return new Attribute(
            get: fn() => $this->records()->where('status', 1)->count()
        );
    }

    protected function okCount(): Attribute
    {
        return new Attribute(
            get: fn() => $this->records()->where('status', 0)->count()
        );
    }
}
