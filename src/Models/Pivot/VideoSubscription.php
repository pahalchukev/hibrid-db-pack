<?php

namespace HibridVod\Database\Models\Pivot;

use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Models\BasePivotModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Subscription\Subscription;

/**
 * Class VideoSubscription
 * @package HibridVod\Database\Models\Pivot
 */
class VideoSubscription extends BasePivotModel
{
    /**
     * @var string
     */
    protected $table = 'video_subscription';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'video_id',
        'subscription_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}
