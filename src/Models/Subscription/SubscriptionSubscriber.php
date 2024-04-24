<?php

namespace HibridVod\Database\Models\Subscription;

use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Models\Tenant\ApiClient;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class Subscription
 * @package HibridVod\Database\Models\Subscription
 */
class SubscriptionSubscriber extends BaseModel implements EntityInterface, HasUuid
{
    use UsesSystemConnection;
    use Uuidable;

    protected $table = 'subscription_subscribers';
    public const TVOD_TYPE = 'tvod';
    public const SVOD_TYPE = 'svod';

    /**
     * @var bool
     */
    public $incrementing = false;

    public $timestamps = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'subscription_id',
        'subscriber_id',
        'price',
        'type',
        'tenant_id',
        'api_client_id',
        'created_at',
    ];

    /**
     * @return BelongsTo
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * @return BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * @return BelongsTo
     */
    public function apiClient(): BelongsTo
    {
        return $this->belongsTo(ApiClient::class);
    }
}
