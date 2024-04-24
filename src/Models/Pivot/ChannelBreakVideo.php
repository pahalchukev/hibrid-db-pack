<?php

namespace HibridVod\Database\Models\Pivot;

use HibridVod\Database\Models\BasePivotModel;
use HibridVod\Database\Models\Channel\Channel;
use HibridVod\Database\Models\Video\Video;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChannelBreakVideo extends BasePivotModel
{
    /**
     * @var string
     */
    protected $table = 'channel_break_video';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'channel_id',
        'video_id',
        'intro_id',
        'outro_id',
    ];

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class)->whereNull('deleted_at');
    }

    public function intro(): BelongsTo
    {
        return $this->belongsTo(Video::class, 'intro_id')->whereNull('deleted_at');
    }

    public function outro(): BelongsTo
    {
        return $this->belongsTo(Video::class, 'outro_id')->whereNull('deleted_at');
    }
}
