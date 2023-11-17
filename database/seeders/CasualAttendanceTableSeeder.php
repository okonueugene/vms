<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CasualAttendance;
use App\Models\Casual;
use Carbon\Carbon;

class CasualAttendanceTableSeeder extends Seeder
{
    public function run()
    {
        $casuals = Casual::all();

        $startDate = Carbon::create(2023, 10, 1);
        $endDate = Carbon::now();

        foreach ($casuals as $casual) {
            $usedDates = [];

            // Randomize the number of dates to generate for each casual
            $numberOfDates = 39
            ;
            for ($i = 0; $i < $numberOfDates; $i++) {
                // Generate a unique random date within the specified range
                do {
                    $randomDate = Carbon::create(
                        rand($startDate->year, $endDate->year),
                        rand($startDate->month, $endDate->month),
                        rand($startDate->day, $endDate->day)
                    );
                } while (in_array($randomDate->toDateString(), $usedDates));

                $usedDates[] = $randomDate->toDateString();

                // Random clock-in and clock-out times
                $clockIn = $randomDate->copy()->setTime(rand(8, 12), rand(0, 59), rand(0, 59));
                $clockOut = $randomDate->copy()->setTime(rand(13, 17), rand(0, 59), rand(0, 59));

                CasualAttendance::create([
                    'casual_id' => $casual->id,
                    'date' => $randomDate->toDateString(),
                    'clock_in' => $clockIn->toTimeString(),
                    'clock_out' => $clockOut->toTimeString(),
                ]);
            }
        }
    }
}
