<?php

namespace HibridVod\Database\Models\Subscription;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Video\Video;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Pivot\VideoSubscription;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class Subscription
 * @package HibridVod\Database\Models\Subscription
 */
class Subscription extends BaseModel implements HasUuid, EntityInterface
{
    use UsesSystemConnection;
    use HasDefaultRelations;
    use SoftDeletes;
    use Uuidable;

    public const TVOD_TYPE = 'tvod';

    public const SVOD_TYPE = 'svod';

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
        'created_by',
        'tenant_id',
        'title',
        'time',
        'price',
        'type',
        'is_active',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function video(): BelongsToMany
    {
        return $this->belongsToMany(
            Video::class,
            VideoSubscription::getShortTableName(),
            null,
            null,
            null,
            null
        )
            ->using(VideoSubscription::class)
            ->withTimestamps();
    }
}
