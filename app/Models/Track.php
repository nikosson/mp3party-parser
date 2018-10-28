<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property $id
 * @property $name
 * @property $track_id
 * @property $src_path
 * @property $storage_path
 * @property $artist_id
 */
class Track extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'track_id',
        'src_path',
        'storage_path',
        'artist_id'
    ];

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function scopeNotDownloaded(Builder $query): Builder
    {
        return $query->whereNull('storage_path');
    }

    public function scopeDownloaded(Builder $query): Builder
    {
        return $query->whereNotNull('storage_path');
    }

    public function isDownloaded(): bool
    {
        return isset($this->local_path);
    }
}
