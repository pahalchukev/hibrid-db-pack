<?php

namespace HibridVod\Database\Models\Video;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class Thumbnail
 * @package HibridVod\Database\Models\Video
 */
class Thumbnail extends BaseModel implements HasUuid, EntityInterface
{
    use UsesSystemConnection;
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
     * Default collection name.
     *
     * @var string
     */
    protected $table = 'video_thumbnails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'video_id',
        'name',
        'path',
        'url',
        'type',
        'on_second',
        'is_default',
        'source',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
}
