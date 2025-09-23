<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'name',
        'type',
        'verification_type',
        'location',
        'status',
        'handler'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getStatusLabelAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status 
            ? '<span class="badge bg-success">Active</span>' 
            : '<span class="badge bg-danger">Inactive</span>';
    }

    public function startups()
    {
        return $this->hasMany(Startup::class);
    }

    public function products()
    {
        return $this->hasMany(DeviceProduct::class);
    }
}
