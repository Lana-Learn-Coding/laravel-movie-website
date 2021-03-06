<?php

namespace App\Models\Movie;

use App\Models\BaseModel;
use App\Models\MovieCountable;

/**
 * App\Models\Movie\MovieGenre
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Movie\Movie[] $movies
 * @property-read int|null $movies_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movie\MovieGenre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movie\MovieGenre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movie\MovieGenre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movie\MovieGenre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movie\MovieGenre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movie\MovieGenre whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movie\MovieGenre whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movie\MovieGenre manyMovie($count = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel toPage($size = 12)
 */
class MovieGenre extends BaseModel
{
    use MovieCountable;

    protected $fillable = [
        "name"
    ];

    public function movies()
    {
        return $this->belongsToMany("App\Models\Movie\Movie");
    }
}
