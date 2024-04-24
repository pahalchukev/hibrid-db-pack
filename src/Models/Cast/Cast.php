<?php

namespace HibridVod\Database\Models\Cast;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Category\Category;
use HibridVod\Database\Models\Playlist\Playlist;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Video\Video;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Traits\CustomHasTranslations;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class Tag
 * @package HibridVod\Database\Models\Tag
 * @property-read \Illuminate\Database\Eloquent\Relations\Pivot $pivot
 */
class Cast extends BaseModel implements HasUuid, EntityInterface
{
    use UsesSystemConnection;
    use SoftDeletes;
    use Uuidable;
    use ExtraEventsTrait;
    use HasDefaultRelations;
    use CustomHasTranslations;

    protected $table = 'casts';
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'reference_id',
        'title',
        'title_trans',
        'description',
        'description_trans',
        'country',
        'country_trans',
        'dob',
        'tenant_id',
        'created_by',
        'created_at',
        'updated_at'
    ];

    /**
     * @var string[]
     */
    public $translatable = ['title_trans', 'description_trans', 'country_trans'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function posters(): HasMany
    {
        return $this->hasMany(CastPoster::class);
    }

    public function videos(): BelongsToMany
    {
        return $this->belongsToMany(
            Video::class,
            "video_casts",
            null,
            null,
            null,
            null
        )
            ->withTimestamps();
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            "category_casts",
            null,
            null,
            null,
            null
        )
            ->withTimestamps();
    }

    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(
            Playlist::class,
            "playlist_casts",
            null,
            null,
            null,
            null
        )
            ->withTimestamps();
    }
}
