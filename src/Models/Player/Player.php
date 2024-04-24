<?php

namespace HibridVod\Database\Models\Player;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Models\Traits\HasTenantId;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;
use HibridVod\Database\Models\Advertisement\AdvertisementTag;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Player
 * @package HibridVod\Database\Models\Player
 */
class Player extends BaseModel implements HasUuid, EntityInterface, Auditable
{
    use UsesSystemConnection;
    use HasDefaultRelations;
    use SoftDeletes;
    use Uuidable;
    use AuditableTrait;
    use HasTenantId {
        HasTenantId::transformAudit insteadof AuditableTrait;
    }
    use ExtraEventsTrait;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_default' => false,
    ];

    /**
     * @var array<string>
     */
    protected $casts = [
        'options' => 'json',
        'is_default' => 'boolean',

        'blocked_links' => 'json',
        'allowed_links' => 'json'
    ];

    /**
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'type',
        'options',
        'is_default',
        'created_by',
        'tenant_id',

        'domain_status',
        'blocked_links',
        'allowed_links',

        'advertisement_tag_id'
    ];

    /**
     * @var array<string>
     */
    protected $auditInclude = [
        'title',
        'type',
        'options',
        'is_default',
        'created_by',
        'tenant_id',

        'domain_status',
        'blocked_links',
        'allowed_links',

        'advertisement_tag_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(AdvertisementTag::class, 'advertisement_tag_id');
    }
}
