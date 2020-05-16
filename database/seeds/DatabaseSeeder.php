<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

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

        $timelines = factory(\App\Timeline::class, 5)->create();
        $periodtypes = factory(\App\Periodtype::class, 5)->create();


        $tlper = new \App\TimelinePeriod();
    }
}
