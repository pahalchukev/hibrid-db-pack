<?php

namespace HibridVod\Database\Models\Stream;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

class DelayedStreamSchedule extends BaseModel implements HasUuid
{
    use UsesSystemConnection;
    use Uuidable;

    public const UPDATED_AT = null;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'delayed_stream_schedules';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'stream_id',
        'delayed_stream_id',
        'command',
        'execute_at',
        'executed_at',
    ];

    /**
     * @var array<string>
     */
    protected $dates = [
        'execute_at',
        'executed_at',
    ];

    /**
     * @return BelongsTo
     */
    public function delayedStream(): BelongsTo
    {
        return $this->belongsTo(DelayedStream::class);
    }

    /**
     * @return BelongsTo
     */
    public function stream(): BelongsTo
    {
        return $this->belongsTo(LiveStream::class);
    }
}
