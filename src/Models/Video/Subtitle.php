<?php

namespace HibridVod\Database\Models\Video;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class Subtitle
 * @package HibridVod\Database\Models\Video
 */
class Subtitle extends BaseModel implements HasUuid, EntityInterface
{
    use UsesSystemConnection;
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
     * Default collection name.
     *
     * @var string
     */
    protected $table = 'video_subtitles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'file_name',
        'path',
        'url',
        'size',
        'extension',
        'is_active',
        'language',
        'video_id',
        'created_by',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
}
