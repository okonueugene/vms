<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Casual;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CasualsController extends Controller
{
    public function updateClockStatus($official_identification_number)
    {
        $casual = Casual::where('official_identification_number', $official_identification_number)->first();

        if ($casual) {
            // Check if there is a record for the current day
            $attendanceRecord = $casual->casualAttendance()->whereDate('date', now()->toDateString())->first();

            if ($attendanceRecord) {
                // Attendance record exists for the current day
                if ($attendanceRecord->clock_out) {
                    // Clock-out value is already set, return error
                    return response()->json(['message' => 'You have already clocked out for today'], 400);
                } else {

                    if ($attendanceRecord->clock_in) {
                        // Clock-in value is already set, update clock-out
                        $attendanceRecord->update(['clock_out' => now()]);
                        $message = 'Clock-out time updated successfully';
                    } else {
                        // Clock-in value is not set, update clock-in
                        $attendanceRecord->update(['clock_in' => now(),'date' => now()->toDateString()]);
                        $message = 'Clock-in time updated successfully';
                    }
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
