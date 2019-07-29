<?php

use Illuminate\Database\Seeder;
use App\Schedule;

class Update10AMSchedulesGracePeriod extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schedule::where('starts_at', '10:00')->update(['grace_period' => 0]);
    }
}
