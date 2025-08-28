<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shift;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shifts = [
            [
                'name' => 'Shift 1',
                'start_time' => '06:00',
                'end_time' => '14:00',
            ],
            [
                'name' => 'Shift 2',
                'start_time' => '14:00',
                'end_time' => '22:00',
            ],
            [
                'name' => 'Shift 3',
                'start_time' => '22:00',
                'end_time' => '06:00',
            ],
        ];

        foreach ($shifts as $shift) {
            Shift::create($shift);
        }
    }
}
