<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'startup_id',
        'por_id',
        'item_id',
        'product_name',
        'batch_number',
        'product_specifications',
        'product_type',
        'target_quantity',
        'unit',
        'prod_pool_id',
        'schedule_date',
        'scanned_at'
    ];

    protected $casts = [
        'product_specifications' => 'array'
    ];

    public function startup()
    {
        return $this->belongsTo(Startup::class);
    }
}
