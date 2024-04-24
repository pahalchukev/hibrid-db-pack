<?php

namespace HibridVod\Database\Models\Video;

use HibridVod\Database\Models\CustomField\CustomField;
use HibridVod\Database\Models\Subscriber\Subscriber;
use HibridVod\Database\Models\Subscriber\SubscriberLike;
use HibridVod\Database\Models\Traits\CustomHasTranslations;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use OwenIt\Auditing\Auditable as AuditableTrait;
use ScoutElastic\Searchable;
use HibridVod\Database\Models\Tag\Tag;
use HibridVod\Database\Models\Cast\Cast;
use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use HibridVod\Database\Models\Tenant\Tenant;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Pivot\VideoTag;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Category\Category;
use HibridVod\Database\Models\Playlist\Playlist;
use HibridVod\Database\Models\Pivot\VideoCategory;
use HibridVod\Database\Models\Pivot\PlaylistVideo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\Pivot\VideoSubscription;
use HibridVod\Database\Models\Subscription\Subscription;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;
use HibridVod\Database\Models\Video\Search\VideosIndexConfigurator;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Video
 * @package HibridVod\Database\Models\Video
 * @property-read \HibridVod\Database\Models\Tenant\Tenant $tenant
 * @property-read \Illuminate\Database\Eloquent\Relations\Pivot $pivot
 */
class Video extends BaseModel implements HasUuid, EntityInterface, Auditable
{
    use Uuidable;
    use Searchable;
    use SoftDeletes;
    use AuditableTrait;
    use ExtraEventsTrait;
    use HasDefaultRelations;
    use UsesSystemConnection;
    use CustomHasTranslations;

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
    protected $indexConfigurator = VideosIndexConfigurator::class;

    /**
     * @var string[]
     */
    public $translatable = ['title_trans', 'description_trans'];

    /**
     * @var array<string, array|string>
     */
    protected $mapping = [
        'properties' => [
            'title' => [
                'type' => 'text',
                'analyzer' => 'autocomplete',
                'search_analyzer' => 'autocomplete',
                'fields' => [
                    'ar' => [
                        'type' => 'text',
                        'analyzer' => 'arabic'
                    ],
                ]
            ],
            'title_trans' => [
                'type' => 'text',
                'analyzer' => 'autocomplete',
                'search_analyzer' => 'autocomplete',
                'fields' => [
                    'ar' => [
                        'type' => 'text',
                        'analyzer' => 'arabic',
                    ],
                ],
            ],
            'custom_trans' => [
                "type" => "text",
                "analyzer" => "custom_comma_analyzer"
            ],
            'description' => [
                'type' => 'text',
                'analyzer' => 'text',
                'fields' => [
                    'ar' => [
                        'type' => 'text',
                        'analyzer' => 'arabic'
                    ],
                ]
            ],
            'description_trans' => [
                'type' => 'text',
                'analyzer' => 'text',
                'fields' => [
                    'ar' => [
                        'type' => 'text',
                        'analyzer' => 'arabic'
                    ],
                ]
            ],
            'tenant_id' => [
                'type' => 'keyword',
            ],
        ],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'size',
        'path',
        'mime',
        'url',
        'title',
        'created_by',
        'tenant_id',
        'thumbnail',
        'is_active',
        'is_featured',
        'is_approved',
        'is_ready',
        'reference_id',
        'meta_info',
        'duration',
        'video_quality',
        'smil_file',
        'extension',
        'file_name',
        'original_file_name',
        'storage_original_name',
        'description',
        'content_path',
        'played_count',
        'svod_status',
        'converted_at',
        'recorded_at',
        'title_trans',
        'description_trans',
        'activate_date',
        'inactivate_date',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'svod_status' => false,
        'is_active' => true,
        'is_featured' => false,
    ];

    /**
     * @var array<string>
     */
    protected $hidden = [
        'storage_original_name',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $casts = [
        'meta_info' => 'json',
        'is_active' => 'boolean',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'is_ready' => 'boolean',
        'svod_status' => 'boolean',
        'recorded_at' => 'datetime',
    ];

    /**
     * @var array<string>
     */
    protected $appends = [
        'human_time',
    ];

    /**
     * @var array<string>
     */
    protected $auditInclude = [
        'title',
        'created_by',
        'tenant_id',
        'thumbnail',
        'is_active',
        'is_featured',
        'is_approved',
        'is_ready',
        'meta_info',
        'file_name',
        'original_file_name',
        'description',
        'svod_status',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            VideoTag::getShortTableName(),
            null,
            null,
            null,
            null
        )
            ->using(VideoTag::class)
            ->withTimestamps();
    }

    public function casts(): BelongsToMany
    {
        return $this->belongsToMany(
            Cast::class,
            "video_casts",
            null,
            null,
            null,
            null
        )
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function thumbnails(): HasMany
    {
        return $this->hasMany(Thumbnail::class)->orderByDesc('is_default');
    }

    /**
     * @return HasMany
     */
    public function posters(): HasMany
    {
        return $this->hasMany(Poster::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(
            Subscription::class,
            VideoSubscription::getShortTableName(),
            null,
            null,
            null,
            null
        )
            ->using(VideoSubscription::class)
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(
            Playlist::class,
            PlaylistVideo::getShortTableName(),
            null,
            null,
            null,
            null,
            PlaylistVideo::class // @phpstan-ignore-line
        )
            ->using(VideoSubscription::class)
            ->withTimestamps();
    }

    /**
     * This association is useful if we need to get only ids of associated playlists
     * without making additional inner join to load playlists as well
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function playlistsPivot(): HasMany
    {
        return $this->hasMany(PlaylistVideo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subtitles(): HasMany
    {
        return $this->hasMany(Subtitle::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blockCountries(): HasMany
    {
        return $this->hasMany(VideoBlockedCountry::class);
    }

    public function allowCountries(): HasMany
    {
        return $this->hasMany(VideoAllowedCountry::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(
            Subscriber::class,
            SubscriberLike::getShortTableName(),
            null,
            null,
            null,
            null,
            SubscriberLike::class
        )
            ->using(SubscriberLike::class)
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function trailers(): BelongsToMany
    {
        return $this->belongsToMany(
            Video::class,
            'videos_trailers',
            'video_id',
            'trailer_id'
        )->withPivot(['title', 'order']);
    }

    /**
     * @return BelongsToMany
     */
    public function customFields(): BelongsToMany
    {
        return $this->belongsToMany(
            CustomField::class,
            'video_custom_fields',
            'video_id',
            'custom_field_id'
        )->withPivot(['date', 'string', 'text', 'boolean', 'json', 'translation_json']);
    }

    /**
     * @return \HibridVod\Database\Models\Traits\BelongsToMany
     */
    public function categoryTrailer(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'category_video_trailers',
            null
        )->withPivot(['title', 'order']);
    }

    /**
     * @return array<string>
     */
    public function toSearchableArray(): array
    {
        $array = $this->only([
            'title',
            'description',
            'tenant_id',
            'reference_id'
        ]);

        // get the values of the translations and concatenate them in the same field
        foreach ($this->translatable as $translatable) {
            $trans = [];
            foreach ($this->getTranslations($translatable) as $locale => $value) {
                $trans[] = $value;
            }
            $array[$translatable] = implode(', ', $trans);
        }
        $trs = [];
        foreach ($this->customFields as $custom) {
            if ($custom->pivot->translation_json) {
                $trans = json_decode($custom->pivot->translation_json, true);
                if (is_array($trans)) {
                    foreach ($trans as $tran) {
                        if ($tran) {
                            $trs[] = $tran;
                        }
                    }
                }
            }
        }
        if (!empty($trs)) {
            $array['custom_trans'] = implode(',', $trs);
        }

        return $array;
    }

    /**
     * @return bool
     */
    public function shouldBeSearchable(): bool
    {
        return $this->getAttribute('is_ready')
            && $this->getAttribute('is_active')
            && $this->getAttribute('is_approved')
            && $this->getAttribute('converted_at')
            && $this->getAttribute('synced_at');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param array<string>|string $tags
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTags(Builder $builder, $tags): Builder
    {
        $tags = is_string($tags) ? explode(',', $tags) : $tags;

        return $builder->whereHas('tags', function (Builder $relation) use ($tags) {
            return $relation->whereIn($relation->getModel()->getTable() . '.id', $tags);
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param array<string>|string $categories
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCategories(Builder $builder, $categories): Builder
    {
        $categories = is_string($categories) ? explode(',', $categories) : $categories;

        return $builder->whereHas('categories', function (Builder $relation) use ($categories) {
            return $relation->whereIn($relation->getModel()->getTable() . '.id', $categories);
        });
    }

    /**
     * @param array<mixed> $data
     * @return array<mixed>
     */
    public function transformAudit(array $data): array
    {
        // @phpstan-ignore-next-line
        $data['tenant_id'] = auth()->user()->tenant_id ?? $this->getAttribute('tenant_id');
        $data['title'] = $this->getAttribute('title');
        return $data;
    }

    /**
     * @return false|string
     */
    protected function getHumanTimeAttribute()
    {
        return gmdate('H:i:s', $this->duration);
    }
}
