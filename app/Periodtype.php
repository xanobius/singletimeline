<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Periodtype
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Periodtype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Periodtype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Periodtype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Periodtype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Periodtype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Periodtype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Periodtype whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Periodtype extends Model
{
    //
    public function timelinePeriods()
    {
        return $this->hasMany(TimelinePeriod::class);
    }
}
