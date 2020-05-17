<?php

namespace App\Http\Controllers;

use App\Helpers\Chain;
use App\Schedule;
use App\TimelinePeriod;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimelinePeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $chain = new Chain(
//            Carbon::now()->startOfMonth(),
//            Carbon::now()->endOfMonth(),
            Carbon::create(2020, 5, 1),
            Carbon::create(2020, 6, 31),
            'DEFAULT TEMPLATE'
        );

        $schedule = Schedule::get();

//        dd($schedule);
        $start = microtime(true);

        $chain->insertSchedule($schedule[0], 'Template 2');

        dump(microtime(true) - $start);

//        $chain->insertSchedule($schedule[1], 'Template 3');
        $chain->insertSchedule($schedule[2], 'Template 4');

        dump(microtime(true) - $start);
        dump('Searches: ' . Schedule::$searches);

        return $chain->getChain();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TimelinePeriod  $timelinePeriod
     * @return \Illuminate\Http\Response
     */
    public function show(TimelinePeriod $timelinePeriod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TimelinePeriod  $timelinePeriod
     * @return \Illuminate\Http\Response
     */
    public function edit(TimelinePeriod $timelinePeriod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TimelinePeriod  $timelinePeriod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimelinePeriod $timelinePeriod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TimelinePeriod  $timelinePeriod
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimelinePeriod $timelinePeriod)
    {
        //
    }
}
