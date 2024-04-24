<?php

namespace HibridVod\Database\Models\RemoteSync;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Tenant\Tenant;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;
use HibridVod\Database\Models\RemoteSync\Observers\ConnectionObserver;

/**
 * Class Connection
 * @package HibridVod\Database\Models\RemoteSync
 * @property string                                        $name
 * @property string                                        $alias
 * @property boolean                                       $is_locked
 * @property-read \HibridVod\Database\Models\Tenant\Tenant $tenant
 */
class Connection extends BaseModel implements HasUuid, EntityInterface
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
    protected $table = 'remote_sync_connections';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'alias',
        'adapter',
        'created_by',
        'tenant_id',
        'is_enabled',
        'is_locked',
        'fetched_videos',
        'fetched_size',
        'last_connected_at',
        'adapter_config',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $casts = [
        'adapter_config' => 'json',
    ];

    /**
     * Boot the model
     *
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();
        static::observe(ConnectionObserver::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * @return void
     */
    public function switchIsLocked(): void
    {
        $this->setAttribute('is_locked', ! $this->getAttribute('is_locked'));
        $this->save();
    }
}
