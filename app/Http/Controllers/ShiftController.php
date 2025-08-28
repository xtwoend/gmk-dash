<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Shift::query();
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'LIKE', "%{$search}%");
        }
        
        $shifts = $query->orderBy('start_time')->paginate(10);
        $currentShift = Shift::getCurrentShift();
        
        return view('shifts.index', compact('shifts', 'currentShift'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shifts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        Shift::create($validated);

        return redirect()->route('shifts.index')
            ->with('success', 'Shift created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        return view('shifts.show', compact('shift'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        return view('shifts.edit', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        $shift->update($validated);

        return redirect()->route('shifts.index')
            ->with('success', 'Shift updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift)
    {
        $shift->delete();

        return redirect()->route('shifts.index')
            ->with('success', 'Shift deleted successfully.');
    }
}
