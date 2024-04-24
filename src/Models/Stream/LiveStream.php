<?php

namespace HibridVod\Database\Models\Stream;

use HibridVod\Database\Models\BaseModel;
use OwenIt\Auditing\Contracts\Auditable;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Tenant\Tenant;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use HibridVod\Database\Models\Traits\HasTenantId;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class LiveStream
 * @package HibridVod\Database\Models\Stream
 */
class LiveStream extends BaseModel implements HasUuid, EntityInterface, Auditable
{
    use UsesSystemConnection;
    use SoftDeletes;
    use Uuidable;
    use AuditableTrait;
    use HasTenantId {
        HasTenantId::transformAudit insteadof AuditableTrait;
    }
    use ExtraEventsTrait;

    /**
     * Offline status of stream
     */
    public const OFFLINE = false;

    /**
     * Online status of stream
     */
    public const ONLINE = true;

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
        'title',
        'dvr_server_id',
        'dvr_server_ip',
        'dvr_id',
        'dvr_options',
        'nimble_secret',
        'tenant_id',
        'is_catchup',
        'max_editing_duration',
        'last_recording_time'
    ];

    /**
     * @var array<string>
     */
    protected $auditInclude = [
        'title',
        'dvr_server_id',
        'dvr_server_ip',
        'dvr_id',
        'dvr_options',
        'nimble_secret',
        'tenant_id',
    ];

    /**
     * @var array<string>
     */
    protected $appends = [
        'stream_url',
    ];

    /**
     * @param string|null $val
     * @return object
     */
    public function getDvrOptionsAttribute(?string $val): object
    {
        if (!$val) {
            return new \stdClass();
        }
        $object = json_decode($val);
        if (!$object) {
            return new \stdClass();
        }
        return $object;
    }

    /**
     * Get wms stream prefix attribute
     *
     * @return string
     */
    protected function getStreamUrlAttribute(): string
    {
        $options = $this->dvr_options;
        $application = $options->application ?? '';
        $stream = $options->stream ?? '';
        return "https://{$this->dvr_server_ip}/" . $application . "/" . $stream . "/playlist.m3u8";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * @return HasMany
     */
    public function delayedStreams(): HasMany
    {
        return $this->hasMany(DelayedStream::class, 'stream_id', 'id');
    }
}
