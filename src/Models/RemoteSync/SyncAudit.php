<?php

namespace HibridVod\Database\Models\RemoteSync;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class SyncAudits
 * @package HibridVod\Database\Models\RemoteSync
 */
class SyncAudit extends BaseModel implements HasUuid, EntityInterface
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
    protected $table = 'remote_sync_connection_audits';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'state',
        'context',
        'connection_id',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $casts = [
        'context' => 'json',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function connection(): BelongsTo
    {
        return $this->belongsTo(Connection::class)->select(['id', 'name', 'adapter']);
    }
}
