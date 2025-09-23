<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceProduct;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DeviceProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $deviceId = request('device_id', null);
        $deviceProducts = DeviceProduct::with('device')
            ->when($deviceId, fn($query) => $query->where('device_id', $deviceId))
            ->paginate(15);
            
        return view('device-products.index', compact('deviceProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $devices = Device::active()->get();
        return view('device-products.create', compact('devices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'product_code' => 'required|string|max:255',
        ]);

        DeviceProduct::create([
            'device_id' => $request->device_id,
            'product_code' => $request->product_code,
        ]);

        return redirect()->route('device-products.index')
            ->with('success', 'Device product assigned successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DeviceProduct $deviceProduct): View
    {
        $deviceProduct->load('device');
        return view('device-products.show', compact('deviceProduct'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeviceProduct $deviceProduct): View
    {
        $devices = Device::active()->get();
        return view('device-products.edit', compact('deviceProduct', 'devices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeviceProduct $deviceProduct): RedirectResponse
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'product_code' => 'required|string|max:255',
        ]);

        $deviceProduct->update([
            'device_id' => $request->device_id,
            'product_code' => $request->product_code,
        ]);

        return redirect()->route('device-products.index')
            ->with('success', 'Device product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeviceProduct $deviceProduct): RedirectResponse
    {
        $deviceProduct->delete();

        return redirect()->route('device-products.index')
            ->with('success', 'Device product deleted successfully.');
    }
}
