<?php

namespace HibridVod\Database\Models\Pivot;

use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Models\BasePivotModel;
use HibridVod\Database\Models\Playlist\Playlist;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PlaylistVideo
 * @package HibridVod\Database\Models\Pivot
 */
class PlaylistVideo extends BasePivotModel
{
    /**
     * @var string
     */
    protected $table = 'playlist_video';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'playlist_id',
        'video_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function playlist(): BelongsTo
    {
        return $this->belongsTo(Playlist::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
}
