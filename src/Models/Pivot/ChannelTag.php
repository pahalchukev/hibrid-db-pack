<?php

namespace HibridVod\Database\Models\Pivot;

use HibridVod\Database\Models\Channel\Channel;
use HibridVod\Database\Models\Tag\Tag;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChannelTag extends \HibridVod\Database\Models\BasePivotModel
{
    /**
     * @var string
     */
    protected $table = 'channel_tag';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'channel_id',
        'tag_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function playlist(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
