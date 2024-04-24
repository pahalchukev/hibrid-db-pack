<?php

namespace HibridVod\Database\Models\Pivot;

use HibridVod\Database\Models\Category\Category;
use HibridVod\Database\Models\Channel\Channel;
use HibridVod\Database\Models\BasePivotModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChannelCategory extends BasePivotModel
{
    /**
     * @var string
     */
    protected $table = 'channel_categories';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'channel_id',
        'category_id',
    ];

    /**
     * @return BelongsTo
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
