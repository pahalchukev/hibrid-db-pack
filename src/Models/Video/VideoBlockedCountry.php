<?php

namespace HibridVod\Database\Models\Video;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

class VideoBlockedCountry extends BaseModel implements EntityInterface
{
    use UsesSystemConnection;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'video_id',
        'country_code'
    ];
}
