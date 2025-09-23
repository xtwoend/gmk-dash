<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceProduct extends Model
{
    protected $fillable = [
        'device_id',
        'product_code',
    ];

    /**
     * Get the device that owns the device product
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * Assign a product to a device
     */
    public static function assignProductToDevice($deviceId, $productCode)
    {
        return self::updateOrCreate(
            ['device_id' => $deviceId],
            ['product_code' => $productCode]
        );
    }
}
