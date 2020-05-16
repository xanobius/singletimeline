<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function schedulable()
    {
        return $this->morphTo();
    }
}
