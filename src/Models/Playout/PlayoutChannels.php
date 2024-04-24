<?php

namespace HibridVod\Database\Models\Playout;

use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Repository\Contracts\EntityInterface;

class PlayoutChannels extends BaseModel implements HasUuid, EntityInterface
{
    use UsesSystemConnection;
    use Uuidable;
    use ExtraEventsTrait;

    public $incrementing = false;
    public $table = 'playout_channels';

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

    public function instance(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Playout::class, 'id', 'instance_id');
    }
}
