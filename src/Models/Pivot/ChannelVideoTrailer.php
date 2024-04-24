<?php

namespace HibridVod\Database\Models\Pivot;

class ChannelVideoTrailer extends \HibridVod\Database\Models\BasePivotModel
{
    /**
     * @var string
     */
    protected $table = 'channel_video_trailers';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'channel_id',
        'video_id',
    ];
}
