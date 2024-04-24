<?php

namespace HibridVod\Database\Models\Pivot;

use HibridVod\Database\Models\BasePivotModel;
use HibridVod\Database\Models\Channel\Schedule;
use HibridVod\Database\Models\Video\Video;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleVideo extends BasePivotModel
{
    /**
     * @var string
     */
    protected $table = 'schedule_videos';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'schedule_id',
        'video_id',
        'start_time',
        'start_time_ts',
        'finish_time_ts',
        'finish_time',
        'start_second'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
}
