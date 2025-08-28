<?php

namespace App\Http\Controllers\Api;

use App\Models\Shift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShiftController extends Controller
{
    public function active(Request $request)
    {
       $shift = Shift::getCurrentShift();

        return response()->json($shift);
    }
}
