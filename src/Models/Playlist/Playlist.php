<?php

namespace HibridVod\Database\Models\Playlist;

use HibridVod\Database\Models\Category\Category;
use HibridVod\Database\Models\Tag\Tag;
use HibridVod\Database\Models\Cast\Cast;
use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Models\Traits\HasTenantId;
use HibridVod\Database\Models\Video\Video;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Pivot\PlaylistTag;
use HibridVod\Database\Models\Pivot\PlaylistVideo;
use HibridVod\Database\Models\Pivot\PlaylistCategory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Traits\CustomHasTranslations;
use HibridVod\Database\Repository\Contracts\EntityInterface;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Playlist
 * @package HibridVod\Database\Models\Playlist
 */
class Playlist extends BaseModel implements HasUuid, EntityInterface, Auditable
{
    use CustomHasTranslations;
    use UsesSystemConnection;
    use HasDefaultRelations;
    use SoftDeletes;
    use Uuidable;
    use AuditableTrait;
    use HasTenantId {
        HasTenantId::transformAudit insteadof AuditableTrait;
    }
    use ExtraEventsTrait;

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
        'reference_id',
        'title',
        'description',
        'thumbnail',
        'is_active',
        'created_by',
        'tenant_id',
        'title_trans',
        'description_trans'
    ];

    /**
     * @var string[]
     */
    public $translatable = ['title_trans', 'description_trans'];

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
        'reference_id',
        'title',
        'description',
        'thumbnail',
        'is_active',
        'created_by',
        'tenant_id',
        'title_trans',
        'description_trans'
    ];

    /**
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            if (is_null($model->reference_id)) {
                $model->reference_id = $model->makeReferenceId();
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function videos(): BelongsToMany
    {
        // @phpstan-ignore-next-line
        return $this->belongsToMany(
            Video::class,
            PlaylistVideo::getShortTableName(),
            null,
            null,
            null,
            null
        )
            ->using(PlaylistVideo::class)
            ->withTimestamps()
            ->orderBy('playlist_video.id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            PlaylistTag::getShortTableName(),
            null,
            null,
            null,
            null
        )
            ->using(PlaylistTag::class)
            ->withTimestamps();
    }

    public function casts(): BelongsToMany
    {
        return $this->belongsToMany(
            Cast::class,
            "playlist_casts",
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
            PlaylistCategory::getShortTableName(),
            null,
            null,
            null,
            null
        )
            ->using(PlaylistCategory::class)
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function trailers(): BelongsToMany
    {
        return $this->belongsToMany(
            Video::class,
            'playlist_video_trailers'
        )->withPivot(['title']);
    }


    /**
     * @return string
     */
    public function makeReferenceId(): string
    {
        return sha1($this->tenant ? $this->tenant->getKey() : '' . $this->getAttribute('title'));
    }
}
