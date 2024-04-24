<?php

namespace HibridVod\Database\Models\Video;

use OwenIt\Auditing\Contracts\Auditable;
use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Tenant\ApiClient;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Video\ValueObjects\Priority;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class RemoteVideo
 * @package HibridVod\Database\Models\Video
 * @property-read \HibridVod\Database\Models\Tenant\Tenant $tenant
 * @property-read \Illuminate\Database\Eloquent\Relations\Pivot $pivot
 */
class RemoteVideo extends BaseModel implements HasUuid, EntityInterface, Auditable
{
    use UsesSystemConnection;
    use Uuidable;
    use AuditableTrait;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'video_url',
        'webhook_url',
        'should_activate',
        'tags_ids',
        'should_activate',
        'tenant_id',
        'video_id',
        'api_client_id',
        'processed_at',
        'reference_id',
        'priority',
        'fetched_at',
        'download_from',
        'parent_video_id'
    ];

    /**
     * @var array<string, mixed>
     */
    protected $casts = [
        'tags_ids' => 'json',
        'should_activate' => 'boolean',
    ];

    /**
     * @var array<string>
     */
    protected $auditInclude = [
        'title',
        'description',
        'video_url',
        'webhook_url',
        'should_activate',
        'tags_ids',
        'should_activate',
        'tenant_id',
        'video_id',
        'api_client_id',
        'reference_id',
        'parent_video_id'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function apiClient(): BelongsTo
    {
        return $this->belongsTo(ApiClient::class);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function transformAudit(array $data): array
    {
        $data['tenant_id'] = $this->getAttribute('tenant_id');
        $data['title'] = $this->getAttribute('title');
        return $data;
    }

    /**
     * @param Priority $priority
     * @return void
     */
    public function setPriorityAttribute(Priority $priority): void
    {
        $this->attributes['priority'] = $priority->getValue();
    }

    /**
     * @return string
     */
    public function getPriorityAttribute(): string
    {
        return Priority::fromValue($this->attributes['priority'])->getSlug();
    }
}
