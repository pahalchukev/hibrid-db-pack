<?php

namespace HibridVod\Database\Models\Tenant;

use HibridVod\Database\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class StorageUsage
 * @package HibridVod\Database\Models\Tenant
 */
class StorageUsage extends BaseModel implements EntityInterface
{
    use UsesSystemConnection;

    /**
     * Default table name
     *
     * @var string
     */
    protected $table = 'tenant_storage_usages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'used',
        'tenant_id',
        'filled_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
