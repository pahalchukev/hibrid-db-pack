<?php

namespace HibridVod\Database\Models\Pivot;

use HibridVod\Database\Models\Tag\Tag;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Models\BasePivotModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class VideoTag
 * @package HibridVod\Database\Models\Pivot
 */
class VideoTag extends BasePivotModel
{
    /**
     * @var string
     */
    protected $table = 'video_tag';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'video_id',
        'tag_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
