<?php

namespace HibridVod\Database\Models\Stream;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Video\RemoteVideo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

class LiveStreamSeat extends BaseModel implements HasUuid, EntityInterface
{
    use UsesSystemConnection;
    use HasDefaultRelations;
    use Uuidable;

    public const UPDATED_AT = null;

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
        'stream_id',
        'created_by',
        'tenant_id',
        'is_active',
        'start_timestamp',
        'end_timestamp',
        'remote_video_id'
    ];

    /**
     * @return BelongsTo
     */
    public function liveStream(): BelongsTo
    {
        return $this->belongsTo(LiveStream::class, 'stream_id');
    }

    /**
     * @return BelongsTo
     */
    public function remoteVideo(): BelongsTo
    {
        return $this->belongsTo(RemoteVideo::class);
    }
}
