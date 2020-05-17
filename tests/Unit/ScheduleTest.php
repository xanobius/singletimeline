<?php

namespace Tests\Unit;

use App\Timeline;
use App\Periodtype;
use App\TimelinePeriod;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testWeekdaysInRangeAcceptance ()
    {
        $schedule = $this->createWeekdaySchedule();

        $this->assertTrue($schedule->hasBlockInPeriod(
            Carbon::create(2020, 6, 1), // Monday
            Carbon::create(2020, 6, 2)  // Tuesday
        ));
        $this->assertTrue($schedule->hasBlockInPeriod(
            Carbon::create(2020, 6, 4, 0), // Thursday
            Carbon::create(2020, 6, 6, 23) // Saturday
        ));
    }

    public function testInvalidWeekdaysInRangeRefuse ()
    {

        $schedule = $this->createWeekdaySchedule();

        $this->assertFalse($schedule->hasBlockInPeriod(
            Carbon::create(2020, 6, 2, 0), // Tuesday
            Carbon::create(2020, 6, 2, 23) // Tuesday
        ));

        $this->assertFalse($schedule->hasBlockInPeriod(
            Carbon::create(2020, 6, 6, 0), // Saturday
            Carbon::create(2020, 6, 7, 23) // Sunday
        ));
    }

    public function testValidRangeAcceptance ()
    {
        $schedule = $this->createDaterangeSchedule();

        // Joining
        $this->assertTrue($schedule->hasBlockInPeriod(
            Carbon::create(2020, 6, 1, 0), // before Range
            Carbon::create(2020, 6, 3, 0) // in Range
        ));

        // Leaving
        $this->assertTrue($schedule->hasBlockInPeriod(
            Carbon::create(2020, 6, 4, 0), // in Range
            Carbon::create(2020, 6, 7, 0)  // after Range
        ));

        // block IN
        $this->assertTrue($schedule->hasBlockInPeriod(
            Carbon::create(2020, 6, 4, 0), // in Range
            Carbon::create(2020, 6, 5, 0)  // in Range
        ));

        // block Arround
        $this->assertTrue($schedule->hasBlockInPeriod(
            Carbon::create(2020, 6, 1, 0), // before Range
            Carbon::create(2020, 6, 7, 0)  // after Range
        ));
    }

    public function testInvalidRangeRefuse ()
    {
        $schedule = $this->createDaterangeSchedule();

        // Before
        $this->assertFalse($schedule->hasBlockInPeriod(
            Carbon::create(2020, 5, 20, 0), // before Range
            Carbon::create(2020, 6, 1, 0)  // before Range
        ));

        // After
        $this->assertFalse($schedule->hasBlockInPeriod(
            Carbon::create(2020, 6, 10, 0), // after Range
            Carbon::create(2020, 6, 12, 0)  // after Range
        ));
    }

    public function testValidTimeRangeAcceptance ()
    {
        $schedule = $this->createTimerangeSchedule();

        // Joining
        $this->assertTrue($schedule->hasBlockInPeriod(
            Carbon::create(2020, 6, 1, 8), // before Range
            Carbon::create(2020, 6, 1, 10) // in Range
        ));

        // Leaving
        $this->assertTrue($schedule->hasBlockInPeriod(
            Carbon::create(2020, 6, 1, 10), // in Range
            Carbon::create(2020, 6, 1, 20)  // after Range
        ));

        // block IN
        $this->assertTrue($schedule->hasBlockInPeriod(
            Carbon::create(2020, 6, 1, 10), // in Range
            Carbon::create(2020, 6, 1, 11)  // in Range
        ));

        // block Arround
        $this->assertTrue($schedule->hasBlockInPeriod(
            Carbon::create(2020, 6, 1, 8), // before Range
            Carbon::create(2020, 6, 1, 20)  // after Range
        ));

    }

    public function testInvalidTimeRangeRefuse ()
    {
        $schedule = $this->createTimerangeSchedule();

        // Before
        $this->assertFalse($schedule->hasBlockInPeriod(
            Carbon::create(2020, 6, 1, 8), // before Range
            Carbon::create(2020, 6, 1, 8, 58) // before Range
        ));

        // After
        $this->assertFalse($schedule->hasBlockInPeriod(
            Carbon::create(2020, 6, 1, 20), // after Range
            Carbon::create(2020, 6, 1, 21) // after Range
        ));
    }

    public function testCorrectBlockWithDatesReturn ()
    {
        $schedule = $this->getFullblownSchedule();

        $times = $schedule->getNextBlock(
            Carbon::create(2020, 6, 2),
            Carbon::create(2020, 6, 5)
        );

        $this->assertTrue($times[0]->format('YmdHi') == '202006030900');
        $this->assertTrue($times[1]->format('YmdHi') == '202006031600');


        $times = $schedule->getNextBlock(
            Carbon::create(2020, 6, 3, 10),
            Carbon::create(2020, 6, 3, 12)
        );

        $this->assertTrue($times[0]->format('YmdHi') == '202006031000');
        $this->assertTrue($times[1]->format('YmdHi') == '202006031200');

        $times = $schedule->getNextBlock(
            Carbon::create(2020, 6, 3, 10),
            Carbon::create(2020, 6, 4, 12)
        );

        $this->assertTrue($times[0]->format('YmdHi') == '202006031000');
        $this->assertTrue($times[1]->format('YmdHi') == '202006031600');


        $times = $schedule->getNextBlock(
            Carbon::create(2020, 6, 2, 10),
            Carbon::create(2020, 6, 3, 12)
        );

        $this->assertTrue($times[0]->format('YmdHi') == '202006030900');
        $this->assertTrue($times[1]->format('YmdHi') == '202006031200');

    }

    public function testEmptyBlockReturn ()
    {
        $schedule = $this->getFullblownSchedule();

        $this->assertFalse($schedule->getNextBlock(
            Carbon::create(2020, 5, 1),
            Carbon::create(2020, 6, 1, 8, 0)
        ));

        $this->assertFalse($schedule->getNextBlock(
            Carbon::create(2020, 6, 29, 17),
            Carbon::create(2020, 7, 1 )
        ));

        $this->assertFalse($schedule->getNextBlock(
            Carbon::create(2020, 6, 12, 16, 01),
            Carbon::create(2020, 6, 15, 8, 59)
        ));
    }

    private function getFullblownSchedule()
    {
        $tlper = factory(TimelinePeriod::class)->create();
        $schedule = new Schedule();
        $schedule->type = config('timeline.schedule_types.weekdays') +
            config('timeline.schedule_types.timerange') +
            config('timeline.schedule_types.daterange');
        $schedule->weekdays =config('timeline.weekdays.monday') +
            config('timeline.weekdays.wednesday') +
            config('timeline.weekdays.friday');
        $schedule->dateStart = Carbon::create(2020, 6, 1);
        $schedule->dateEnd = Carbon::create(2020, 6, 10);
        $schedule->timeStart = '09:00';
        $schedule->timeEnd = '16:00';
        $schedule->schedulable()->associate($tlper);
        $schedule->save();
        return $schedule;
    }

    private function createWeekdaySchedule()
    {
        $tlper = factory(TimelinePeriod::class)->create();

        $schedule = new Schedule();
        $schedule->type = config('timeline.schedule_types.weekdays');
        $schedule->weekdays =config('timeline.weekdays.monday') +
            config('timeline.weekdays.wednesday') +
            config('timeline.weekdays.friday');
        $schedule->schedulable()->associate($tlper);
        $schedule->save();
        return $schedule;
    }

    private function createDaterangeSchedule()
    {
        $tlper = factory(TimelinePeriod::class)->create();

        $schedule = new Schedule();
        $schedule->type = config('timeline.schedule_types.daterange');
        $schedule->dateStart = Carbon::create(2020, 6, 2);
        $schedule->dateEnd = Carbon::create(2020, 6, 5);
        $schedule->schedulable()->associate($tlper);
        $schedule->save();
        return $schedule;
    }

    private function createTimerangeSchedule()
    {
        $tlper = factory(TimelinePeriod::class)->create();

        $schedule = new Schedule();
        $schedule->type = config('timeline.schedule_types.timerange');
        $schedule->timeStart = '09:00';
        $schedule->timeEnd = '16:00';
        $schedule->schedulable()->associate($tlper);
        $schedule->save();
        return $schedule;
    }
}
