<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Device::query();
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('type', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%")
                  ->orWhere('handler', 'LIKE', "%{$search}%")
                  ->orWhere('verification_type', 'LIKE', "%{$search}%");
            });
        }
        
        $devices = $query->latest()->paginate(10);
        
        return view('devices.index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('devices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'verification_type' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'handler' => 'nullable|string|max:255',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;

        Device::create($validated);

        return redirect()->route('devices.index')
            ->with('success', 'Device created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        return view('devices.show', compact('device'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'verification_type' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'handler' => 'nullable|string|max:255',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;

        $device->update($validated);

        return redirect()->route('devices.index')
            ->with('success', 'Device updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        $device->delete();

        return redirect()->route('devices.index')
            ->with('success', 'Device deleted successfully.');
    }

    /**
     * Toggle device status
     */
    public function toggleStatus(Device $device)
    {
        $device->update([
            'status' => !$device->status
        ]);

        $statusText = $device->status ? 'activated' : 'deactivated';
        
        return redirect()->route('devices.index')
            ->with('success', "Device {$statusText} successfully.");
    }
}
