<?php

namespace HibridVod\Database\Models\Pivot;

use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Models\BasePivotModel;
use HibridVod\Database\Models\Category\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class VideoCategory
 * @package HibridVod\Database\Models\Pivot
 */
class VideoCategory extends BasePivotModel
{
    /**
     * @var string
     */
    protected $table = 'video_category';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'video_id',
        'category_id',
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
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
