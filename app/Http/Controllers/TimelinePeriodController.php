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
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
            'DEFAULT TEMPLATE'
        );

        $schedule = Schedule::first();

        dump($chain->getChain());

        $chain->insertSchedule($schedule, 'Template 2');

        dump($chain->getChain());
        return '';
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
