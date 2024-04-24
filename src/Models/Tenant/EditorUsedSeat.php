<?php

namespace HibridVod\Database\Models\Tenant;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Video\RemoteVideo;
use HibridVod\Database\Models\Video\Video;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

class EditorUsedSeat extends BaseModel implements EntityInterface
{
    use UsesSystemConnection;

    public const UPDATED_AT = null;

    /**
     * Default table name
     *
     * @var string
     */
    protected $table = 'tenant_editor_used_seats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'tenant_id',
        'video_id',
        'user_id',
        'is_active',
        'remote_video_id'
    ];

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
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function remoteVideo(): BelongsTo
    {
        return $this->belongsTo(RemoteVideo::class);
    }
}
