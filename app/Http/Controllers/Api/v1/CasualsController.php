<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Casual;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CasualsController extends Controller
{
    public function updateClockStatus(Request $request)
    {
        $requestData = $request->all();

        // Validate the request data as needed...

        if ($request->has('official_identification_number')) {
            $casual = Casual::where('official_identification_number', $request->official_identification_number)->first();
        } elseif ($request->has('phone')) {
            $casual = Casual::where('phone', $request->phone)->first();
        } else {
            return response()->json(['message' => 'Please provide either official identification number or phone number of a registered casual'], 400);
        }

        if ($casual) {
            // Check if there is a record for the current day
            $attendanceRecord = $casual->casualAttendance()->whereDate('date', now()->toDateString())->first();

            if ($attendanceRecord) {
                // Attendance record exists for the current day
                if ($attendanceRecord->clock_in) {
                    // Clock-in value is already set, update clock-out
                    $attendanceRecord->update(['clock_out' => now()]);
                    $message = 'Clock-out time updated successfully';
                } elseif($attendanceRecord->clock_out) {
                    $message = 'You have been checked out successfully';
                } else {
                    // Clock-in value is not set, update clock-in
                    $attendanceRecord->update(['clock_in' => now(),'date' => now()->toDateString()]);
                    $message = 'Clock-in time updated successfully';
                }
            } else {
                // No attendance record for the current day, create a new one
                $casual->casualAttendance()->create([
                    'casual_id' => $casual->id,
                    'date' => now()->toDateString(),
                    'clock_in' => now(),
                ]);
                $message = 'Clock-in time recorded successfully';
            }

            return response()->json(['message' => $message], 200);
        } else {
            return response()->json(['message' => 'Casual not found. Please register first.'], 404);
        }
    }

}
