<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schedules = collect([
            [
                "dimulai" => "07:30:00",
                "berakhir" => "09:30:00"
            ],
            [
                "dimulai" => "08:30:00",
                "berakhir" => "10:30:00"
            ],
            [
                "dimulai" => "09:30:00",
                "berakhir" => "11:30:00"
            ],
            [
                "dimulai" => "10:30:00",
                "berakhir" => "12:30:00"
            ]
        ]);

        $schedules->each(function($schedule) {
            Schedule::create($schedule);
        });
    }
}
