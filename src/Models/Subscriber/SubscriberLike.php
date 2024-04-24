<?php

namespace HibridVod\Database\Models\Subscriber;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Video\Video;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class UserLike
 * @package App\Models\UserLike
 */
class SubscriberLike extends BaseModel implements HasUuid, EntityInterface
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
     * @var array<string>
     */
    protected $fillable = [
        'subscriber_id',
        'video_id',
        'like'
    ];

    /**
     * @return belongsTo
     */
    public function subscriber(): belongsTo
    {
        return $this->belongsTo(Subscriber::class);
    }

    /**
     * @return belongsTo
     */
    public function video(): belongsTo
    {
        return $this->belongsTo(Video::class);
    }
}
