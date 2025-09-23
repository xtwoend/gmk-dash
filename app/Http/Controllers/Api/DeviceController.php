<?php

namespace App\Http\Controllers\Api;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        $devices = Device::active()->with('products')->get();

        // Logic to retrieve and return a list of devices
        return response()->json($devices);
    }

    public function show($id)
    {
        $device = Device::find($id);

        if (! $device) {
            return response()->json(['error' => 'Device not found'], 404);
        }

        // Logic to retrieve and return a specific device by ID
        return response()->json($device);
    }
}
