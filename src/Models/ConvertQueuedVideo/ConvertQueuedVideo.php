<?php

namespace HibridVod\Database\Models\ConvertQueuedVideo;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Video\RemoteVideo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

class ConvertQueuedVideo extends BaseModel implements HasUuid
{
    use UsesSystemConnection;
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
     * @var string[]
     */
    protected $fillable = [
        'video_id',
        'tenant_id',
        'converted_at',
        'failed_at',
        'failed_exception',
        'is_converting',
        'is_downloading',
        'is_storing',
        'downloaded_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function video(): BelongsTo
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
}
