<?php

namespace HibridVod\Database\Models\Tenant;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class ApiClient
 * @package HibridVod\Database\Models\Tenant
 */
class ApiClient extends BaseModel implements HasUuid, EntityInterface
{
    use UsesSystemConnection;
    use HasDefaultRelations;
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
    protected $table = 'tenant_api_clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'client_id',
        'access_token',
        'created_by',
        'tenant_id',
        'is_active',
    ];
}
