<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timelines')->delete();
        DB::table('periodtypes')->delete();
        DB::table('timeline_periods')->delete();
        DB::table('schedules')->delete();

        $timelines = factory(\App\Timeline::class, 2)->create();
        $periodtypes = factory(\App\Periodtype::class, 5)->create();

        $tlper = new \App\TimelinePeriod();
        $tlper->timeline()->associate($timelines[0]);
        $tlper->periodtype()->associate($periodtypes[0]);
        $tlper->is_default = true;
        $tlper->save();


        /* New Period-Content for 3 Weekdays during day */
        $tlper = new \App\TimelinePeriod();
        $tlper->timeline()->associate($timelines[0]);
        $tlper->periodtype()->associate($periodtypes[1]);
        $tlper->save();

        $schedule = new \App\Schedule();
        $schedule->type = config('timeline.schedule_types.weekdays') + config('timeline.schedule_types.timerange');
        $schedule->weekdays =config('timeline.weekdays.monday') +
            config('timeline.weekdays.wednesday') +
            config('timeline.weekdays.friday');
        $schedule->timeStart = '09:00';
        $schedule->timeEnd = '16:00';
        $schedule->schedulable()->associate($tlper);
        $schedule->save();


        /* New Period-Content for a daterange at night hours */
        $tlper = new \App\TimelinePeriod();
        $tlper->timeline()->associate($timelines[0]);
        $tlper->periodtype()->associate($periodtypes[2]);
        $tlper->save();

        $schedule = new \App\Schedule();
        $schedule->type = config('timeline.schedule_types.daterange') + config('timeline.schedule_types.timerange');
        $schedule->dateStart = \Carbon\Carbon::create(2020, 6, 1);
        $schedule->dateStart = \Carbon\Carbon::create(2020, 6, 31);
        $schedule->timeStart = '20:00';
        $schedule->timeEnd = '23:00';
        $schedule->schedulable()->associate($tlper);
        $schedule->save();
    }
}
