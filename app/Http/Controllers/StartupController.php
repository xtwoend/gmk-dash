<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use App\Models\Device;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StartupController extends Controller
{
    public function index(Request $request)
    {
        $query = Startup::with(['device', 'user', 'verifications', 'records']);
        
        // Filter by device if specified
        if ($request->has('device_id') && $request->device_id) {
            $query->where('device_id', $request->device_id);
        }
        
        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('startup_date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('startup_date', '<=', $request->date_to);
        }
        
        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        $startups = $query->orderBy('startup_date', 'desc')->paginate(15);
        $devices = Device::all();
        
        return view('startups.index', compact('startups', 'devices'));
    }
    
    public function report(Request $request)
    {
        $devices = Device::all();
        
        // Get date range (default to current month)
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));
        
        // Build base query
        $query = Startup::with(['device', 'user'])
            ->whereDate('startup_date', '>=', $dateFrom)
            ->whereDate('startup_date', '<=', $dateTo);
        
        // Filter by device if specified
        if ($request->has('device_id') && $request->device_id) {
            $query->where('device_id', $request->device_id);
        }
        
        $startups = $query->get();
        
        // Group startups by device
        $deviceReports = [];
        
        foreach ($devices as $device) {
            if ($request->has('device_id') && $request->device_id && $device->id != $request->device_id) {
                continue;
            }
            
            $deviceStartups = $startups->where('device_id', $device->id);
            
            if ($deviceStartups->count() > 0) {
                $deviceReports[] = [
                    'device' => $device,
                    'total_startups' => $deviceStartups->count(),
                    'active_startups' => $deviceStartups->where('status', 1)->count(),
                    'paused_startups' => $deviceStartups->where('status', 2)->count(),
                    'completed_startups' => $deviceStartups->where('status', 3)->count(),
                    'total_ok_records' => $deviceStartups->sum('ok_count'),
                    'total_ng_records' => $deviceStartups->sum('ng_count'),
                    'startups' => $deviceStartups->sortByDesc('startup_date')
                ];
            }
        }
        
        // Summary statistics
        $summary = [
            'total_devices' => count($deviceReports),
            'total_startups' => $startups->count(),
            'total_active' => $startups->where('status', 1)->count(),
            'total_paused' => $startups->where('status', 2)->count(),
            'total_completed' => $startups->where('status', 3)->count(),
            'grand_total_ok' => $startups->sum('ok_count'),
            'grand_total_ng' => $startups->sum('ng_count'),
        ];
        
        return view('startups.report', compact('deviceReports', 'summary', 'devices', 'dateFrom', 'dateTo'));
    }
    
    public function show($id)
    {
        $startup = Startup::with([
            'device', 
            'user', 
            'verifications', 
            'activities', 
            'products', 
            'records'
        ])->findOrFail($id);
        
        return view('startups.show', compact('startup'));
    }
    
    public function analytics(Request $request)
    {
        $devices = Device::all();
        
        // Get date range (default to last 30 days)
        $dateFrom = $request->get('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));
        
        // Daily startup counts by device
        $dailyData = Startup::select(
                DB::raw('DATE(startup_date) as date'),
                'device_id',
                DB::raw('COUNT(*) as startup_count')
            )
            ->whereDate('startup_date', '>=', $dateFrom)
            ->whereDate('startup_date', '<=', $dateTo)
            ->groupBy('date', 'device_id')
            ->orderBy('date')
            ->get();
        
        // Status distribution by device
        $statusData = Startup::select(
                'device_id',
                'status',
                DB::raw('COUNT(*) as count')
            )
            ->whereDate('startup_date', '>=', $dateFrom)
            ->whereDate('startup_date', '<=', $dateTo)
            ->groupBy('device_id', 'status')
            ->get();
        
        // Performance metrics by device
        $performanceData = Startup::select(
                'device_id',
                DB::raw('COUNT(*) as total_startups'),
                DB::raw('SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) as completed_startups'),
                DB::raw('AVG(CASE WHEN status = 3 THEN TIMESTAMPDIFF(HOUR, startup_date, updated_at) ELSE NULL END) as avg_completion_hours')
            )
            ->whereDate('startup_date', '>=', $dateFrom)
            ->whereDate('startup_date', '<=', $dateTo)
            ->groupBy('device_id')
            ->get();
        
        return view('startups.analytics', compact(
            'devices', 
            'dailyData', 
            'statusData', 
            'performanceData',
            'dateFrom', 
            'dateTo'
        ));
    }

    public function ngConfirm(Request $request)
    {
        $request->validate([
            'record_id' => 'required|exists:records,id'
        ]);
        
        $qa = $request->user();

        $record = \App\Models\Record::find($request->record_id);
        $record->qa_id = $qa->id;
        $record->save();

        return redirect()->back()->with('success', 'NG record verified successfully.');
    }

    public function verificationConfirm(Request $request)
    {
        $request->validate([
            'verification_id' => 'required|exists:verifications,id'
        ]);
        
        $foreman = $request->user();

        $verification = \App\Models\Verification::find($request->verification_id);
        $verification->foreman_id = $foreman->id;
        $verification->save();

        return redirect()->back()->with('success', 'Verification confirmed successfully.');
    }
}
