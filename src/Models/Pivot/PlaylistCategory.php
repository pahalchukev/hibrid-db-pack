<?php

namespace HibridVod\Database\Models\Pivot;

use HibridVod\Database\Models\Category\Category;
use HibridVod\Database\Models\BasePivotModel;
use HibridVod\Database\Models\Playlist\Playlist;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PlaylistCategory
 * @package HibridVod\Database\Models\Pivot
 */
class PlaylistCategory extends BasePivotModel
{
    /**
     * @var string
     */
    protected $table = 'playlist_categories';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'playlist_id',
        'category_id',
    ];

    /**
     * @return BelongsTo
     */
    public function playlist(): BelongsTo
    {
        return $this->belongsTo(Playlist::class);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
