<?php

namespace HibridVod\Database\Models\Stream;

use HibridVod\Database\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Traits\Uuidable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use HibridVod\Database\Models\Traits\HasTenantId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

class DelayedStream extends BaseModel implements HasUuid, EntityInterface, Auditable
{
    use UsesSystemConnection;
    use HasDefaultRelations;
    use Uuidable;
    use AuditableTrait;
    use HasTenantId {
        HasTenantId::transformAudit insteadof AuditableTrait;
    }


    public const ONE_TIME_TYPE = 'oneTime';

    public const SPECIFIC_DAYS_TYPE = 'schedule';

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
    protected $table = 'delayed_streams';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'stream_id',
        'created_by',
        'tenant_id',
        'title',
        'recording_type',
        'selected_days',
        'start_at',
        'stop_at',
        'stop_recording'
    ];

    /**
     * @var array<array>
     */
    protected $attributes = [
        'selected_days' => [],
    ];

    /**
     * @param string|null $val
     *
     * @return array<string>
     */
    public function getSelectedDaysAttribute(?string $val)
    {
        if (!$val) {
            return [];
        }

        return explode(',', $val);
    }

    /**
     * @return BelongsTo
     */
    public function liveStream(): BelongsTo
    {
        return $this->BelongsTo(LiveStream::class, 'stream_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(DelayedStreamSchedule::class, 'delayed_stream_id', 'id');
    }
}
