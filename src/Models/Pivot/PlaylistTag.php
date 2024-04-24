<?php

namespace HibridVod\Database\Models\Pivot;

use HibridVod\Database\Models\Tag\Tag;
use HibridVod\Database\Models\BasePivotModel;
use HibridVod\Database\Models\Playlist\Playlist;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PlaylistTag
 * @package HibridVod\Database\Models\Pivot
 */
class PlaylistTag extends BasePivotModel
{
    /**
     * @var string
     */
    protected $table = 'playlist_tag';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'playlist_id',
        'tag_id',
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
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
