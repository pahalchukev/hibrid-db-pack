<?php

namespace HibridVod\Database\Models\Advertisement;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class AdvertisementTag
 * @package HibridVod\Database\Models\Advertisement
 */
class AdvertisementTag extends BaseModel implements HasUuid, EntityInterface
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
     * @var string
     */
    protected $table = 'advertisement_tags';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'type',
        'title',
        'tag',
        'tenant_id',
        'created_by',
    ];
}
