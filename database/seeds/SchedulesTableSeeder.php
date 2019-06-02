<?php

use App\Schedule;
use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
{
    protected $schedules = [
        ['7:00', '15:00', 1],
        ['8:00', '16:00', 1],
        ['8:00', '17:00', 1.5],
        ['9:00', '17:00', 1],
        ['9:00', '18:00', 1.5],
        ['10:00', '18:00', 1],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->schedules as $schedule) {
            [$starts_at, $ends_at, $break] = $schedule;
            Schedule::forceCreate([
                'starts_at' => $starts_at,
                'ends_at' => $ends_at,
                'break' => $break
            ]);
        }
    }
}
