<?php

namespace HibridVod\Database\Models\Subscriber;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Subscriber\SubscriberLike;
use HibridVod\Database\Models\Video\Video;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Tenant\ApiClient;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class Subscription
 * @package HibridVod\Database\Models\Subscription
 */
class Subscriber extends BaseModel implements HasUuid, EntityInterface
{
    use UsesSystemConnection;
    use HasDefaultRelations;
    use SoftDeletes;
    use Uuidable;


    protected $table = 'subscribers';
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
        'first_name',
        'last_name',
        'balance',
        'meta_data',
        'status',
        'tenant_id',
        'api_client_id',
        'username',
        'email',
        'phone',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $casts = [
        'meta_data' => 'json',
        'status' => 'boolean',
    ];

    /**
     * @var array<string>
     */
    protected $appends = [
        'full_name',
    ];

    /**
     * @return string
     */
    protected function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

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
    public function apiClient(): BelongsTo
    {
        return $this->belongsTo(ApiClient::class);
    }

    /**
     * @return BelongsToMany
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(
            Video::class,
            SubscriberLike::getFullTableName(),
            null,
            null,
            null,
            null,
            SubscriberLike::class
        )
            ->using(SubscriberLike::class)
            ->withTimestamps();
    }
}
