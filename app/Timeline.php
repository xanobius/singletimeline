<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Timeline
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timeline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timeline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timeline query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timeline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timeline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timeline whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timeline whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Timeline extends Model
{
    //
}
