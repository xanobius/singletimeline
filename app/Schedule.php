<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * App\Schedule
 *
 * @property int $id
 * @property string $schedulable_type
 * @property int $schedulable_id
 * @property int $type
 * @property int|null $weekdays
 * @property string|null $timeStart
 * @property string|null $timeEnd
 * @property string|null $dateStart
 * @property string|null $dateEnd
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereSchedulableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereSchedulableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereTimeEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereTimeStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereWeekdays($value)
 * @mixin \Eloquent
 */
class Schedule extends Model
{
    protected $guarded = [];

    protected $casts = [
        'dateStart' => 'datetime',
        'dateEnd' => 'datetime'
    ];

    public function schedulable()
    {
        return $this->morphTo();
    }

    public function hasBlockInPeriod(Carbon $start, Carbon $end)
    {
        // In Date-Range?
        if ( ($this->type & config('timeline.schedule_types.daterange')) == config('timeline.schedule_types.daterange')) {
            if ($start > $this->dateEnd || $end < $this->dateStart) {
                return false; // Out of bound
            }
        }

        // Valid weekday present?
        if( ($this->type & config('timeline.schedule_types.weekdays')) == config('timeline.schedule_types.weekdays')){
            $valid = false;
            $tmp = clone $start;
            while($tmp->timestamp <= $end->timestamp){
                $valid = $this->isInWeekdays($tmp) ? true : $valid;
                $tmp->addDay();
            }
            if( ! $valid ){
                return false;
            }
        }

        // in time-Range
        if( ($this->type & config('timeline.schedule_types.timerange')) == config('timeline.schedule_types.timerange')) {
                // its only important if its less than 24 hours
            if($start->diff($end)->days < 1){
                if($start->format('H:i:s') > $this->timeEnd || $end->format('H:i:s') < $this->timeStart){
                    return false;
                }
            }
        }

        return true;
    }

    private function isInWeekdays(Carbon $day)
    {
        $wd = config('timeline.weekdays.' . strtolower($day->dayName));
        return ($this->weekdays & $wd) == $wd;
    }
}
