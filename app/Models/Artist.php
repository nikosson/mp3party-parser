<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property $id
 * @property $artist_id
 * @property $name
 */
class Artist extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'artist_id',
        'name'
    ];

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }

    public function downloadedTracks(): HasMany
    {
        return $this->tracks()->downloaded();
    }
}
