<?php

namespace HibridVod\Database\Models\Channel;

use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Models\Cast\Cast;
use HibridVod\Database\Models\Category\Category;
use HibridVod\Database\Models\Pivot\ChannelBreakVideo;
use HibridVod\Database\Models\Pivot\ChannelCategory;
use HibridVod\Database\Models\Pivot\ChannelTag;
use HibridVod\Database\Models\Tag\Tag;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\HasTenantId;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Repository\Contracts\EntityInterface;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Channel extends BaseModel implements HasUuid, EntityInterface, Auditable
{
    use UsesSystemConnection;
    use HasDefaultRelations;
    use SoftDeletes;
    use Uuidable;
    use AuditableTrait;
    use ExtraEventsTrait;
    use HasTenantId {
        HasTenantId::transformAudit insteadof AuditableTrait;
    }

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The model's attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'thumbnail' => null,
    ];

    /**
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'prime_time',
        'prime_time_fill',
        'prime_time_overlap',
        'prime_time_filler',
        'is_active',
        'is_published',
        'created_by',
        'tenant_id',
        'ad_breaks',
        'video_playout_controls',
        'video_dimensions'
    ];

    /**
     * @var array<string, mixed>
     */
    protected $casts = [
        'is_active' => 'bool',
    ];

    /**
     * @var array<string>
     */
    protected $auditInclude = [
        'title',
        'description',
        'thumbnail',
        'is_active',
        'is_published',
        'created_by',
        'tenant_id',
        'ad_breaks',
        'video_playout_controls'
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'channel_id', 'id')
            ->orderBy('schedules.id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            ChannelTag::getShortTableName(),
            null,
            null,
            null,
            null
        )
            ->using(ChannelTag::class)
            ->withTimestamps();
    }
    public function casts(): BelongsToMany
    {
        return $this->belongsToMany(
            Cast::class,
            "channel_cast",
            null,
            null,
            null,
            null
        )
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            ChannelCategory::getShortTableName(),
            null,
            null,
            null,
            null
        )
            ->using(ChannelCategory::class)
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function trailers(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'channel_video_trailers')
            ->withPivot(['title']);
    }

//    public function breakVideo(): HasOne
//    {
//        return $this->hasOne(ChannelBreakVideo::class);
//    }

    public function breakFillers(): HasMany
    {
        return $this->hasMany(ChannelBreakVideo::class)->where('video_id', '!=', null);
    }
    public function introFillers(): HasMany
    {
        return $this->hasMany(ChannelBreakVideo::class)->where('intro_id', '!=', null);
    }
    public function outroFillers(): HasMany
    {
        return $this->hasMany(ChannelBreakVideo::class)->where('outro_id', '!=', null);
    }

    public function filler(): HasOne
    {
        return $this->hasOne(Video::class, 'id', 'prime_time_filler')->whereNull('deleted_at');
    }
}
