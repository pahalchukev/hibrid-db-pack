<?php

namespace HibridVod\Database\Models\Channel;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Pivot\ScheduleVideo;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Repository\Contracts\EntityInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends BaseModel implements HasUuid, EntityInterface
{
    use Uuidable;
    use UsesSystemConnection;
    use SoftDeletes;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'date',
        'start_time',
        'prime_time',
        'prime_time_fill',
        'prime_time_overlap',
        'prime_time_filler',
        'ad_breaks',
        'channel_id',
        'intro_id',
        'intro_duration',
        'outro_id',
        'outro_duration',
        'status',
        'message',
        'hls_history',
        'extra',
    ];

    public function videos(): HasMany
    {
        return $this->hasMany(ScheduleVideo::class)
            ->with('video')
            ->has('video')
            ->orderBy('start_second');
    }


    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    public function intro(): HasOne
    {
        return $this->hasOne(Video::class, 'intro_id')->whereNull('deleted_at');
    }

    public function outro(): HasOne
    {
        return $this->hasOne(Video::class, 'outro_id')->whereNull('deleted_at');
    }

    public function filler(): HasOne
    {
        return $this->hasOne(Video::class, 'id', 'prime_time_filler')->whereNull('deleted_at');
    }
}
