<?php

namespace HibridVod\Database\Models\Cast;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

class CastPoster extends BaseModel implements HasUuid, EntityInterface
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
    protected $table = 'cast_posters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'cast_id',
        'dimensions',
        'path',
        'url',
    ];

    /**
     * @return BelongsTo
     */
    public function cast(): BelongsTo
    {
        return $this->belongsTo(Cast::class);
    }
}
