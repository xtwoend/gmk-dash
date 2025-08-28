<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'startup_id',
        'product_id',
        'record_time',
        'status',
        'remarks',
        'is_reported',
        'is_separated',
        'is_quarantined',
        'qa_id', 
        'qa_confirmed_at'
    ];

    protected $casts = [
        'record_time' => 'datetime',
    ];

    public function startup()
    {
        return $this->belongsTo(Startup::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function qa()
    {
        return $this->belongsTo(User::class, 'qa_id');
    }
}
