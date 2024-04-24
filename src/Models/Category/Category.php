<?php

namespace HibridVod\Database\Models\Category;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Pivot\PlaylistCategory;
use HibridVod\Database\Models\Playlist\Playlist;
use HibridVod\Database\Models\Tag\Tag;
use HibridVod\Database\Models\Cast\Cast;
use HibridVod\Database\Models\Video\Video;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Pivot\VideoCategory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Traits\CustomHasTranslations;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class Category
 * @package HibridVod\Database\Models\Category
 * @property-read \Illuminate\Database\Eloquent\Relations\Pivot $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection $thumbnails
 */
class Category extends BaseModel implements HasUuid, EntityInterface
{
    use CustomHasTranslations;
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
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'created_by',
        'tenant_id',
        'parent_id',
        'reference_id',
        'description',
        'image',
        'title_trans',
        'description_trans'
    ];

    /**
     * @var string[]
     */
    public $translatable = ['title_trans', 'description_trans'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childCategories(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function videos(): BelongsToMany
    {
        return $this->belongsToMany(
            Video::class,
            VideoCategory::getShortTableName(),
            null,
            null,
            null,
            null
        )
            ->using(VideoCategory::class)
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(
            Playlist::class,
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent(): HasOne
    {
        return $this->hasOne(static::class, 'id', 'parent_id');
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeRootOnly(Builder $builder): Builder
    {
        return $builder->whereNull('parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'category_tag'
        );
    }

    public function casts(): BelongsToMany
    {
        return $this->belongsToMany(
            Cast::class,
            "category_casts",
            null,
            null,
            null,
            null,
        )
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function trailers(): BelongsToMany
    {
        return $this->belongsToMany(
            Video::class,
            'category_video_trailers'
        )->withPivot(['order', 'title']);
    }
}
