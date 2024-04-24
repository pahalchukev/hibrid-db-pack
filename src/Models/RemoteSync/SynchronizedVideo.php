<?php

namespace HibridVod\Database\Models\RemoteSync;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Video\RemoteVideo;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Models\Tenant\Tenant;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class SynchronizedVideos
 * @package HibridVod\Database\Models\RemoteSync
 */
class SynchronizedVideo extends BaseModel implements HasUuid, EntityInterface
{
    use UsesSystemConnection;
    use SoftDeletes;
    use Uuidable;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var string
     */
    protected $table = 'remote_sync_synchronized_videos';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'full_path',
        'path',
        'size',
        'extension',
        'file_name',
        'last_modified',
        'video_id',
        'remote_video_id',
        'connection_id',
        'tenant_id',
        'reference_id',
        'converted_at',
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
    public function remoteVideo(): BelongsTo
    {
        return $this->belongsTo(RemoteVideo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function connection(): BelongsTo
    {
        return $this->belongsTo(Connection::class);
    }
}
