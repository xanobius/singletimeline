<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TimelinePeriod
 *
 * @property int $id
 * @property int $timeline_id
 * @property int $periodtype_id
 * @property int $priority
 * @property int $is_default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Periodtype $periodtype
 * @property-read \App\Timeline $timeline
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TimelinePeriod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TimelinePeriod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TimelinePeriod query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TimelinePeriod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TimelinePeriod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TimelinePeriod whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TimelinePeriod wherePeriodtypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TimelinePeriod wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TimelinePeriod whereTimelineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TimelinePeriod whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TimelinePeriod extends Model
{


    public function timeline()
    {
        return $this->belongsTo(Timeline::class, 'timeline_id');
    }

    public function periodtype()
    {
        return $this->belongsTo(Periodtype::class, 'periodtype_id');
    }



}
