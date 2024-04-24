<?php

namespace HibridVod\Database\Models\Tag;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Models\Traits\HasTenantId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Traits\CustomHasTranslations;
use HibridVod\Database\Repository\Contracts\EntityInterface;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Tag
 * @package HibridVod\Database\Models\Tag
 * @property-read \Illuminate\Database\Eloquent\Relations\Pivot $pivot
 */
class Tag extends BaseModel implements HasUuid, EntityInterface, Auditable
{
    use UsesSystemConnection;
    use SoftDeletes;
    use Uuidable;
    use AuditableTrait;
    use HasTenantId {
        HasTenantId::transformAudit insteadof AuditableTrait;
    }
    use ExtraEventsTrait;
    use CustomHasTranslations;


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
        'color',
        'title',
        'tenant_id',
        'category',
        'title_trans'
    ];

    /**
     * @var array<string>
     */
    protected $auditInclude = [
        'color',
        'title',
        'tenant_id',
        'category',
        'title_trans'
    ];

    /**
     * @var string[]
     */
    public $translatable = ['title_trans'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
