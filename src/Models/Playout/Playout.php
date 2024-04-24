<?php

namespace HibridVod\Database\Models\Playout;

use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Models\Channel\Channel;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Repository\Contracts\EntityInterface;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Playout extends BaseModel implements HasUuid, EntityInterface
{
    use UsesSystemConnection;
    use Uuidable;
    use ExtraEventsTrait;

    /**
     * @var bool
     */
    public $incrementing = false;
    public $table = 'playout_instances';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array<string>
     */
    protected $guarded = [
        'id'
    ];

    public function channels(): BelongsToMany
    {
        return $this->belongsToMany(
            Channel::class,
            "playout_channels",
            'instance_id',
            null,
            null,
            null,
        )
            ->withTimestamps();
    }

    public function playoutChannels(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PlayoutChannels::class, 'instance_id', 'id');
    }
}
