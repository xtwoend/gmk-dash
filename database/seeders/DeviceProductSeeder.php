<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\DeviceProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first few devices to assign products
        $devices = Device::take(5)->get();
        
        if ($devices->count() > 0) {
            // Sample product codes
            $productCodes = [
                'PROD-001',
                'PROD-002', 
                'PROD-003',
                'PROD-004',
                'PROD-005'
            ];
            
            foreach ($devices as $index => $device) {
                DeviceProduct::create([
                    'device_id' => $device->id,
                    'product_code' => $productCodes[$index] ?? 'PROD-DEFAULT',
                ]);
            }
            
            $this->command->info('Sample device products created successfully!');
        } else {
            $this->command->warn('No devices found. Please seed devices first.');
        }
    }
}
