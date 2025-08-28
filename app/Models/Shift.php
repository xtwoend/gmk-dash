<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = [
        'name',
        'start_time',
        'end_time'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
    ];
    /**
     * Get the duration of the shift in minutes
     */
    public function getDurationAttribute()
    {
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);
        
        // Handle shifts that span midnight
        if ($end->lessThan($start)) {
            $end->addDay();
        }
        
        return $start->diffInMinutes($end);
    }

    /**
     * Get formatted duration as hours and minutes
     */
    public function getFormattedDurationAttribute()
    {
        $minutes = $this->duration;
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        
        return sprintf('%d hours %d minutes', $hours, $mins);
    }

    /**
     * Scope for active shifts (you can expand this based on business logic)
     */
    public function scopeActive($query)
    {
        return $query->whereNotNull('start_time')->whereNotNull('end_time');
    }

    /**
     * Scope for current shift based on system time
     */
    public function scopeCurrent($query)
    {
        $currentTime = Carbon::now()->format('H:i:s');
        
        return $query->where(function($q) use ($currentTime) {
            // For shifts that don't span midnight (start_time < end_time)
            $q->where(function($subQ) use ($currentTime) {
                $subQ->whereRaw('TIME(start_time) <= TIME(end_time)')
                     ->whereRaw('TIME(?) BETWEEN TIME(start_time) AND TIME(end_time)', [$currentTime]);
            })
            // For shifts that span midnight (start_time > end_time)
            ->orWhere(function($subQ) use ($currentTime) {
                $subQ->whereRaw('TIME(start_time) > TIME(end_time)')
                     ->whereRaw('(TIME(?) >= TIME(start_time) OR TIME(?) <= TIME(end_time))', [$currentTime, $currentTime]);
            });
        });
    }

    /**
     * Get the current active shift based on system time
     * 
     * @return \App\Models\Shift|null
     */
    public static function getCurrentShift()
    {
        return static::active()->current()->first();
    }

    /**
     * Get shift by specific datetime
     * 
     * @param string|\Carbon\Carbon $datetime
     * @return \App\Models\Shift|null
     */
    public static function getShiftByDatetime($datetime)
    {
        $targetTime = Carbon::parse($datetime)->format('H:i:s');
        
        return static::active()->where(function($query) use ($targetTime) {
            // For shifts that don't span midnight (start_time < end_time)
            $query->where(function($subQ) use ($targetTime) {
                $subQ->whereRaw('TIME(start_time) <= TIME(end_time)')
                     ->whereRaw('TIME(?) BETWEEN TIME(start_time) AND TIME(end_time)', [$targetTime]);
            })
            // For shifts that span midnight (start_time > end_time)
            ->orWhere(function($subQ) use ($targetTime) {
                $subQ->whereRaw('TIME(start_time) > TIME(end_time)')
                     ->whereRaw('(TIME(?) >= TIME(start_time) OR TIME(?) <= TIME(end_time))', [$targetTime, $targetTime]);
            });
        })->first();
    }

    /**
     * Scope for shifts active at a specific datetime
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|\Carbon\Carbon $datetime
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAtDatetime($query, $datetime)
    {
        $targetTime = Carbon::parse($datetime)->format('H:i:s');
        
        return $query->where(function($q) use ($targetTime) {
            // For shifts that don't span midnight (start_time < end_time)
            $q->where(function($subQ) use ($targetTime) {
                $subQ->whereRaw('TIME(start_time) <= TIME(end_time)')
                     ->whereRaw('TIME(?) BETWEEN TIME(start_time) AND TIME(end_time)', [$targetTime]);
            })
            // For shifts that span midnight (start_time > end_time)
            ->orWhere(function($subQ) use ($targetTime) {
                $subQ->whereRaw('TIME(start_time) > TIME(end_time)')
                     ->whereRaw('(TIME(?) >= TIME(start_time) OR TIME(?) <= TIME(end_time))', [$targetTime, $targetTime]);
            });
        });
    }

    /**
     * Check if this shift is currently active
     * 
     * @return bool
     */
    public function isCurrentlyActive()
    {
        $currentTime = Carbon::now()->format('H:i:s');
        $startTime = Carbon::parse($this->attributes['start_time'])->format('H:i:s');
        $endTime = Carbon::parse($this->attributes['end_time'])->format('H:i:s');
        
        // For shifts that don't span midnight
        if ($startTime <= $endTime) {
            return $currentTime >= $startTime && $currentTime <= $endTime;
        }
        
        // For shifts that span midnight
        return $currentTime >= $startTime || $currentTime <= $endTime;
    }

    /**
     * Check if this shift is active at a specific datetime
     * 
     * @param string|\Carbon\Carbon $datetime
     * @return bool
     */
    public function isActiveAtDatetime($datetime)
    {
        $targetTime = Carbon::parse($datetime)->format('H:i:s');
        $startTime = Carbon::parse($this->attributes['start_time'])->format('H:i:s');
        $endTime = Carbon::parse($this->attributes['end_time'])->format('H:i:s');
        
        // For shifts that don't span midnight
        if ($startTime <= $endTime) {
            return $targetTime >= $startTime && $targetTime <= $endTime;
        }
        
        // For shifts that span midnight
        return $targetTime >= $startTime || $targetTime <= $endTime;
    }

    public function getEndTimeAttribute()
    {
        $value = $this->attributes['end_time'];
        return Carbon::parse($value)->format('H:i');
    }

    public function getStartTimeAttribute()
    {
        $value = $this->attributes['start_time'];
        return Carbon::parse($value)->format('H:i');
    }


}
