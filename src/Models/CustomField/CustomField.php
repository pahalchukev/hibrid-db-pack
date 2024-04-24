<?php

namespace HibridVod\Database\Models\CustomField;

use HibridVod\Database\Models\BaseModel;
use OwenIt\Auditing\Contracts\Auditable;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Tenant\Tenant;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use HibridVod\Database\Models\Traits\HasTenantId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

class CustomField extends BaseModel implements HasUuid, EntityInterface, Auditable
{
    use UsesSystemConnection;
    use SoftDeletes;
    use Uuidable;
    use AuditableTrait;
    use HasTenantId {
        HasTenantId::transformAudit insteadof AuditableTrait;
    }
    use ExtraEventsTrait;

    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'tenant_id',
        'type',
        'is_active',
        'label',
        'entity_type',
        'options',
        'slug',
        'order'
    ];

    /**
     * @var array<string>
     */
    protected $auditInclude = [
        'tenant_id',
        'type',
        'is_active',
        'label',
        'entity_type',
        'options',
        'slug',
        'order'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'is_active' => 'boolean',
        'options' => 'array'
    ];

    /**
     * @return BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * @return mixed|string
     */
    public function getValueTypeAttribute()
    {
        $type = $this->getAttribute('type');

        if ($type === 'date' || $type === 'datetime') {
            return 'date';
        } elseif ($type === 'string' || $type === 'select' || $type === 'time' || $type === 'translated_select') {
            return 'string';
        } elseif ($type === 'select_multiple' || $type === 'link' || $type === 'translated_select_multiple') {
            return 'json';
        } elseif ($type === 'translated_string' || $type === 'translated_text') {
            return 'translation_json';
        } else {
            return $type;
        }
    }
}
