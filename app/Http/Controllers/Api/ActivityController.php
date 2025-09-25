<?php

namespace App\Http\Controllers\Api;

use App\Models\Shift;
use App\Models\Device;
use App\Models\Record;
use App\Models\Startup;
use App\Service\Gandum;
use App\Models\Activity;
use App\Models\NoiseLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    /**
     * Create new session device for activity
     */
    public function startup(Request $request)
    {
        $deviceId = $request->attributes->get('device_id');
        $user = $request->user();
        $device = Device::findOrFail($deviceId);

        $startup = Startup::firstOrCreate([
            'device_id' => $deviceId,
            'startup_date' => date('Y-m-d'),
        ], [
            'user_id' => $user->id,
            'verification_type' => $device->verification_type
        ]);

        return response()->json($startup->load('device', 'user', 'verifications', 'activities', 'activities.product', 'lastVerification', 'ngRecords', 'ngRecords.product', 'ngRecords.qa'));
    }

    /**
     * Handle the active activity request.
     */
    public function active(Request $request)
    {
        $deviceId = $request->attributes->get('device_id');

        $startup = Startup::with('device', 'user', 'verifications', 'verifications.user', 'verifications.foreman', 'activities', 'activities.product', 'lastVerification', 'ngRecords', 'ngRecords.product', 'ngRecords.qa')
            ->where('device_id', $deviceId)
            ->where('startup_date', now()->toDateString())
            ->first();

        if(! $startup) {
            return response()->json([
                'success' => false,
                'message' => 'No active startup found for this device.'
            ], 404);
        }

        return response()->json($startup);
    }

    /**
     * Pause the activity for a device.
     */
    public function pause(Request $request)
    {
        $deviceId = $request->attributes->get('device_id');
        $user = $request->user();
        
        $reason = $request->input('reason', 'break'); // default reason is 'break'


        $startup = Startup::where('device_id', $deviceId)
            ->where('startup_date', now()->toDateString())
            ->first();

        if(! $startup) {
            return response()->json([
                'success' => false,
                'message' => 'No active startup found for this device.'
            ], 404);
        }

        $startup->status = 2; // paused
        $startup->pause_reason = $reason;
        $startup->pause_time = now();
        $startup->save();

        return response()->json($startup->load('device', 'user', 'verifications', 'activities', 'activities.product', 'lastVerification', 'ngRecords', 'ngRecords.product', 'ngRecords.qa'));
    }

    public function resume(Request $request)
    {
        $deviceId = $request->attributes->get('device_id');
        $user = $request->user();

        $startup = Startup::where('device_id', $deviceId)
            ->where('startup_date', now()->toDateString())
            ->first();

        if(! $startup) {
            return response()->json([
                'success' => false,
                'message' => 'No active startup found for this device.'
            ], 404);
        }

        $startup->status = 1; // active
        $startup->pause_reason = null;
        $startup->pause_time = null;
        $startup->save();

        return response()->json($startup->load('device', 'user', 'verifications', 'activities', 'activities.product', 'lastVerification', 'ngRecords', 'ngRecords.product', 'ngRecords.qa'));
    }

    public function finish(Request $request)
    {
        $deviceId = $request->attributes->get('device_id');
        $userId = $request->input('user_id');

        $startup = Startup::where('device_id', $deviceId)
            ->where('startup_date', now()->toDateString())
            ->first();

        $startup->update([
            'status' => 3
        ]);

        return response()->json($startup->load('device', 'user', 'verifications', 'activities', 'activities.product', 'lastVerification', 'ngRecords', 'ngRecords.product', 'ngRecords.qa')); 
    }

    /**
     * verification
     */
    public function verification(Request $request)
    {
        $deviceId = $request->attributes->get('device_id');
        $userId = $request->input('user_id');
        $shift = Shift::getCurrentShift();
        
        $fe = $request->input('fe');
        $non_fe = $request->input('non_fe');
        $ss = $request->input('ss');

        $startup = Startup::where('device_id', $deviceId)
            ->where('startup_date', now()->toDateString())
            ->first();

        if(! $startup) {
            return response()->json([
                'success' => false,
                'message' => 'No active startup found for this device.'
            ], 404);
        }

        $type = 'Startup';
        
        if($startup->status == 2) {
            if($startup->pause_reason == 'break') {
                $type = 'Setelah Istirahat ' . ($shift ? $shift->name : '');
            } elseif($startup->pause_reason == 'noise') {
                $type = 'Setelah Maintenance';
            } elseif($startup->pause_reason == 'maintenance') {
                $type = 'Setelah Maintenance';
            }
        }

        // Log verification attempt
        $startup->verifications()->create([
            'user_id' => $userId,
            'type' => $type,
            'fe' => $fe,
            'non_fe' => $non_fe,
            'ss' => $ss,
            'status' => ($fe && $non_fe && $ss) ? 1 : 0,
        ]);

        $startup->status = ($fe && $non_fe && $ss) ? 1 : $startup->status; // 1: verified, 0: failed
        $startup->save();

        return response()->json($startup->load('device', 'user', 'verifications', 'activities', 'activities.product', 'lastVerification', 'ngRecords', 'ngRecords.product', 'ngRecords.qa'));
    }

    public function verificationUpdate(Request $request)
    {
        $deviceId = $request->attributes->get('device_id');
     
        $startup = Startup::where('device_id', $deviceId)
            ->where('startup_date', now()->toDateString())
            ->first();

        if(! $startup) {
            return response()->json([
                'success' => false,
                'message' => 'No active startup found for this device.'
            ], 404);
        }

        $lastVerification = $startup->lastVerification;

        if(! $lastVerification) {
            return response()->json([
                'success' => false,
                'message' => 'No verification record found to update.'
            ], 404);
        }

        // Update the last verification attempt
        $lastVerification->update([
            'wor' => $request->input('wor'),
            'foreman_id' => $request->input('foreman_id'),
        ]);
        $startup->save();

        return response()->json($startup->load('device', 'user', 'verifications', 'activities', 'activities.product', 'lastVerification', 'ngRecords', 'ngRecords.product', 'ngRecords.qa'));
    }

    public function detected(Request $request)
    {
        $deviceId = $request->attributes->get('device_id');

        $startup = Startup::where('device_id', $deviceId)
            ->where('startup_date', now()->toDateString())
            ->first();

        if(! $startup) {
            return response()->json([
                'success' => false,
                'message' => 'No active startup found for this device.'
            ], 404);
        }

        // Log detected activity
        $startup->records()->create([
            'product_id' => $startup->currentProduct?->id,
            'record_time' => now(),
            'status' => 1,
            'remarks' => 'Metal Detector detected something'
        ]);

        return response()->json($startup->load('device', 'user', 'verifications', 'activities', 'activities.product', 'lastVerification', 'ngRecords', 'ngRecords.product', 'ngRecords.qa'));
    }

    public function scanProduct(Request $request)
    {
        $deviceId = $request->attributes->get('device_id');
        $userId = $request->user()->id;

        $por = $request->input('por_id');

        $startup = Startup::where('device_id', $deviceId)
            ->where('startup_date', now()->toDateString())
            ->first();

        $por = (new Gandum())->getProduct($por);

        if (!$por || !$startup) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'id' => null,
            'startup_id' => $startup->id,
            'item_id' => $por['itemId'],
            'por_id' => $por['prodId'],
            'product_name' => $por['name'],
            'batch_number' => $por['inventBatchId'] ?? null,
            'product_specifications' => $por['specifications'] ?? null,
            'product_type' => $por['productType'] ?? 'pcs',
            'target_quantity' => $por['qtySched'] ?? null,
            'unit' => $por['unit'] ?? 'pcs',
            'prod_pool_id' => $por['prodPoolId'] ?? null,
            'schedule_date' => isset($por['schedDate']) ? date('Y-m-d H:i:s', strtotime($por['schedDate'])) : null,
            'expired_date' => $por['expDate'],
            'scanned_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Process the product scan
        // $product = $startup->products()->updateOrCreate([
        //     'startup_id' => $startup->id,
        //     'por_id' => $por['prodId'],
        // ], [
        //     'item_id' => $por['itemId'],
        //     'product_name' => $por['name'],
        //     'batch_number' => $por['inventBatchId'] ?? null,
        //     'product_specifications' => $por['specifications'] ?? null,
        //     'product_type' => $por['productType'] ?? 'pcs',
        //     'target_quantity' => $por['qtySched'] ?? null,
        //     'unit' => $por['unit'] ?? 'pcs',
        //     'prod_pool_id' => $por['prodPoolId'] ?? null,
        //     'schedule_date' => isset($por['schedDate']) ? date('Y-m-d H:i:s', strtotime($por['schedDate'])) : null,
        //     'scanned_at' => now(),
        // ]);

        // return response()->json($product);
    }

    public function setProduct(Request $request)
    {
        $deviceId = $request->attributes->get('device_id');

        $startup = Startup::where('device_id', $deviceId)
            ->where('startup_date', now()->toDateString())
            ->first();

        if(! $startup) {
            return response()->json([
                'success' => false,
                'message' => 'No active startup found for this device.'
            ], 404);
        }

        $product = $startup->products()->updateOrCreate([
            'startup_id' => $startup->id,
            'por_id' => $request->input('por_id'),
        ], [
            'item_id' => $request->input('item_id'),
            'product_name' => $request->input('product_name'),
            'batch_number' => $request->input('batch_number'),
            'product_specifications' => $request->input('product_specifications'),
            'product_type' => $request->input('product_type', 'pcs'),
            'target_quantity' => $request->input('target_quantity'),
            'unit' => $request->input('unit', 'pcs'),
            'prod_pool_id' => $request->input('prod_pool_id'),
            'schedule_date' => $request->input('schedule_date') ? date('Y-m-d H:i:s', strtotime($request->input('schedule_date'))) : null,
            'expired_date' => $request->input('expired_date', null),
            'scanned_at' => now(),
            'message' => $request->input('message'),
        ]);

        return response()->json($startup->load('device', 'user', 'verifications', 'activities', 'activities.product', 'lastVerification', 'ngRecords', 'ngRecords.product', 'ngRecords.qa'));
    }

    public function ngConfirm(Request $request)
    {
        $deviceId = $request->attributes->get('device_id');
        $id = $request->input('id');
        $qa_id = $request->input('qa_id');

        $startup = Startup::where('device_id', $deviceId)
            ->where('startup_date', now()->toDateString())
            ->first();

        if(! $startup) {
            return response()->json([
                'success' => false,
                'message' => 'No active startup found for this device.'
            ], 404);
        }

        $record = Record::find($id);
        $record->qa_id = $qa_id;
        $record->qa_confirmed_at = now();
        $record->save();
        

        return response()->json($startup->load('device', 'user', 'verifications', 'activities', 'activities.product', 'lastVerification', 'ngRecords', 'ngRecords.product', 'ngRecords.qa'));
    }

    public function ngAction(Request $request)
    {
        $deviceId = $request->attributes->get('device_id');
        $id = $request->input('id');

        $startup = Startup::where('device_id', $deviceId)
            ->where('startup_date', now()->toDateString())
            ->first();

        if(! $startup) {
            return response()->json([
                'success' => false,
                'message' => 'No active startup found for this device.'
            ], 404);
        }

        $record = Record::find($id);
        if($record) {
            $record->fill($request->only(['is_reported', 'is_separated', 'is_quarantined', 'status']));
            $record->save();
        }

        return response()->json($startup->load('device', 'user', 'verifications', 'activities', 'activities.product', 'lastVerification', 'ngRecords', 'ngRecords.product', 'ngRecords.qa'));
    }

    public function verificationActivity(Request $request)
    {
        $deviceId = $request->attributes->get('device_id');
        $user =  $request->user();
        $startup = Startup::where('device_id', $deviceId)
            ->where('startup_date', now()->toDateString())
            ->first();

        if (!$startup) {
            return response()->json([
                'success' => false,
                'message' => 'No active startup found for this device.'
            ], 404);
        }

        $status = $request->input('status', 2);

        $startup->activities()->create([
            'activity_date' => now(),
            'startup_id' => $startup->id,
            'user_id' => $request->input('user_id', $user->id),
            'product_id' => $startup->currentProduct?->id,
            'ng_qty' => $request->input('ng_qty', $startup->ngCount),
            'recheck_qty' => $startup->okCount,
            'qty' => $request->input('qty', $startup->currentProduct?->target_quantity ?? 0),
            'type' => $request->input('type', $startup->verification_type),
            'status' => $status,
            'remarks' => $request->input('remarks'),

            // Tambahkan informasi tambahan jika diperlukan
            'fe_front' => $request->input('fe_front', 0),
            'fe_middle' => $request->input('fe_middle', 0),
            'fe_back' => $request->input('fe_back', 0),

            'non_fe_front' => $request->input('non_fe_front', 0),
            'non_fe_middle' => $request->input('non_fe_middle', 0),
            'non_fe_back' => $request->input('non_fe_back', 0),

            'ss_front' => $request->input('ss_front', 0),
            'ss_middle' => $request->input('ss_middle', 0),
            'ss_back' => $request->input('ss_back', 0),
        ]);

        return response()->json($startup->load('device', 'user', 'verifications', 'activities', 'activities.product', 'activities.product', 'lastVerification', 'ngRecords', 'ngRecords.product', 'ngRecords.qa'));
    }

    public function verificationActivityUpdate(Request $request)
    {
        $deviceId = $request->attributes->get('device_id');
        $user =  $request->user();
        $startup = Startup::where('device_id', $deviceId)
            ->where('startup_date', now()->toDateString())
            ->first();

        if (!$startup) {
            return response()->json([
                'success' => false,
                'message' => 'No active startup found for this device.'
            ], 404);
        }

        $status = $request->input('status', 2);

        $lastActivity = $startup->activities()->latest()->first();

        if(! $lastActivity) {
            return response()->json([
                'success' => false,
                'message' => 'No verification record found to update.'
            ], 404);
        }

        
        $lastActivity->fill([
            // 'activity_date' => now(),
            // 'startup_id' => $startup->id,
            // 'user_id' => $request->input('user_id', $user->id),
            // 'product_id' => $startup->currentProduct?->id,
            'ng_qty' => $request->input('ng_qty', $startup->ngCount),
            'recheck_qty' => $startup->okCount,
            'qty' => $request->input('qty', $startup->currentProduct?->target_quantity ?? 0),
            // 'status' => $status,
            'remarks' => $request->input('remarks', ($status == 3 ? 'Verifikasi Terlewat oleh '. $user->name : null)),

            // Tambahkan informasi tambahan jika diperlukan
            // 'fe_front' => $request->input('fe_front', 0),
            // 'fe_middle' => $request->input('fe_middle', 0),
            // 'fe_back' => $request->input('fe_back', 0),

            // 'non_fe_front' => $request->input('non_fe_front', 0),
            // 'non_fe_middle' => $request->input('non_fe_middle', 0),
            // 'non_fe_back' => $request->input('non_fe_back', 0),

            // 'ss_front' => $request->input('ss_front', 0),
            // 'ss_middle' => $request->input('ss_middle', 0),
            // 'ss_back' => $request->input('ss_back', 0),

            // 'wor' => $request->input('wor'),
            'foreman_id' => $request->input('foreman_id'),
        ]);
        $lastActivity->save();

        return response()->json($startup->load('device', 'user', 'verifications', 'activities', 'activities.product', 'lastVerification', 'ngRecords', 'ngRecords.product', 'ngRecords.qa'));
    }

    public function getActivity(Request $request, $id)
    {
        $activity = Activity::with('product', 'user', 'foreman', 'startup')->find($id);

        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'Activity not found.'
            ], 404);
        }

        return response()->json($activity);
    }

    public function updateActivity(Request $request, $id)
    {
        $activity = Activity::with('product', 'user', 'foreman', 'startup')->find($id);

        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'Activity not found.'
            ], 404);
        }

        $activity->fill($request->all());
        $activity->save();

        return response()->json($activity);
    }

    public function noiseDetected(Request $request)
    {
        $deviceId = $request->attributes->get('device_id');
        $user = $request->user();
        
        $startup = Startup::where('device_id', $deviceId)
            ->where('startup_date', now()->toDateString())
            ->first();

        if (!$startup) {
            return response()->json([
                'success' => false,
                'message' => 'No active startup found for this device.'
            ], 404);
        }

        // Log the noise detection event
        NoiseLog::create([
            'device_id' => $deviceId,
            'startup_id' => $startup->id,
            'log_time' => now(),
        ]);

        return response()->json($startup->load('device', 'user', 'verifications', 'activities', 'activities.product', 'lastVerification', 'ngRecords', 'ngRecords.product', 'ngRecords.qa'));
    }
}
