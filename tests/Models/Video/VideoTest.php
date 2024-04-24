<?php

namespace HibridVod\Database\Tests\Models\Video;

use HibridVod\Database\Models\Cast\Cast;
use HibridVod\Database\Models\CustomField\CustomField;
use HibridVod\Database\Models\Traits\CustomHasTranslations;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Models\Video\Poster;
use HibridVod\Database\Models\Video\VideoAllowedCountry;
use OwenIt\Auditing\Auditable as AuditableTrait;
use ScoutElastic\Searchable;
use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Tag\Tag;
use HibridVod\Database\Models\Video\Video;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Video\Subtitle;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Video\Thumbnail;
use HibridVod\Database\Models\Category\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Subscription\Subscription;
use HibridVod\Database\Models\Video\VideoBlockedCountry;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;
use Faker\Factory as Faker;

class VideoTest extends TestCase
{
    use DatabaseMigrations, HasDefaultRelationsAsserts;

    private Video $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(Video::class)->create();
    }

    /** @test */
    public function it_should_use_system_connection(): void
    {
        self::assertHasSystemConnection($this->model);
    }

    /** @test */
    public function it_should_have_uuid_id(): void
    {
        self::assertModelHasStringIdentifier($this->model);
    }

    /** @test */
    public function it_should_have_fillable_attributes(): void
    {
        self::assertModelHasFillableColumns($this->model, [
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
        ]);
    }

    /** @test */
    public function it_should_have_list_of_casts_attributes(): void
    {
        self::assertEquals([
            'meta_info' => 'json',
            'is_active' => 'boolean',
            'is_approved' => 'boolean',
            'is_featured' => 'boolean',
            'is_ready' => 'boolean',
            'svod_status' => 'boolean',
            'recorded_at' => 'datetime',
            'title_trans' => 'array',
            'description_trans' => 'array',
        ], $this->model->getCasts());
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            Uuidable::class,
            Searchable::class,
            SoftDeletes::class,
            AuditableTrait::class,
            ExtraEventsTrait::class,
            HasDefaultRelations::class,
            UsesSystemConnection::class,
            CustomHasTranslations::class
        ]);
    }

    /** @test */
    public function it_should_have_tags_relation(): void
    {
        $tags = factory(Tag::class, 4)->create();
        $this->model->tags()->sync($tags->pluck('id'));

        $this->model->tags->each(function (Tag $tag) {
            self::assertEquals(
                $this->model->getKey(), $tag->pivot->getAttribute('video_id')
            );
        });

        self::assertCount(4, $this->model->tags);
        self::assertModelRelationKeys($this->model->tags(), 'video_id', 'tag_id');
    }

    /** @test */
    public function it_should_have_casts_relation(): void
    {
        $casts = factory(Cast::class, 4)->create();
        $this->model->casts()->sync($casts->pluck('id'));

        $this->model->casts->each(function (Cast $cast) {
            self::assertEquals(
                $this->model->getKey(), $cast->pivot->getAttribute('video_id')
            );
        });

        self::assertCount(4, $this->model->casts);
        self::assertModelRelationKeys($this->model->casts(), 'video_id', 'cast_id');
    }

    /** @test */
    public function it_should_have_subscriptions_relation(): void
    {
        $tags = factory(Subscription::class, 4)->create();
        $this->model->subscriptions()->sync($tags->pluck('id'));

        $this->model->subscriptions->each(function (Subscription $subscription) {
            self::assertEquals(
                $this->model->getKey(), $subscription->pivot->getAttribute('video_id')
            );
        });

        self::assertCount(4, $this->model->subscriptions);
        self::assertModelRelationKeys($this->model->subscriptions(), 'video_id', 'subscription_id');
    }

    /** @test */
    public function it_should_have_categories_relation(): void
    {
        $tags = factory(Category::class, 4)->create();
        $this->model->categories()->sync($tags->pluck('id'));

        $this->model->categories->each(function (Category $category) {
            self::assertEquals(
                $this->model->getKey(), $category->pivot->getAttribute('video_id')
            );
        });

        self::assertCount(4, $this->model->categories);
        self::assertModelRelationKeys($this->model->categories(), 'video_id', 'category_id');
    }

    /** @test */
    public function it_should_convert_to_searchable_array(): void
    {
        $this->model->setAttribute('title', 'test title');
        $this->model->setAttribute('description', 'test description');
        $this->model->setAttribute('tenant_id', 'test tenant_id');
        $this->model->setAttribute('title_trans', ['en' => 'title', 'ar' => 'عنوان']);
        $this->model->setAttribute('description_trans', ['en' => 'text', 'ar' => 'النص']);

        $result = $this->model->toSearchableArray();
        self::assertEquals([
            'title', 'description', 'tenant_id', 'reference_id', 'title_trans', 'description_trans'
        ], array_keys($result));

        self::assertEquals('test title', $result['title']);
        self::assertEquals('test description', $result['description']);
        self::assertEquals('title, عنوان', $result['title_trans']);
        self::assertEquals('text, النص', $result['description_trans']);
    }

    /** @test */
    public function it_should_have_thumbnails_relation(): void
    {
        $this->model->thumbnails()->saveMany(
            factory(Thumbnail::class, 3)->make()
        );

        self::assertCount(3, $this->model->thumbnails);

        $this->model->thumbnails->each(function (Thumbnail $thumbnail) {
            self::assertEquals($thumbnail->getAttribute('video_id'), $this->model->getKey());
        });
    }

    /** @test */
    public function it_should_have_posters_relation(): void
    {
        $this->model->posters()->saveMany(
            factory(Poster::class, 3)->make()
        );

        self::assertCount(3, $this->model->posters);

        $this->model->posters->each(function (Poster $poster) {
            self::assertEquals($poster->getAttribute('video_id'), $this->model->getKey());
        });
    }


    /** @test */
    public function it_should_have_subtitles_relation(): void
    {
        $this->model->subtitles()->saveMany(
            factory(Subtitle::class, 3)->make()
        );

        self::assertCount(3, $this->model->subtitles);

        $this->model->subtitles->each(function (Subtitle $subtitle) {
            self::assertEquals($subtitle->getAttribute('video_id'), $this->model->getKey());
        });
    }

    /** @test */
    public function it_should_have_block_countries_relation(): void
    {
        $this->model->blockCountries()->saveMany(
            factory(VideoBlockedCountry::class, 3)->make()
        );

        self::assertCount(3, $this->model->blockCountries);

        $this->model->blockCountries->each(function (VideoBlockedCountry $blockedCountry) {
            self::assertEquals($blockedCountry->getAttribute('video_id'), $this->model->getKey());
        });
    }

    /** @test */
    public function it_should_have_allow_countries_relation(): void
    {
        $this->model->allowCountries()->saveMany(
            factory(VideoAllowedCountry::class, 3)->make()
        );

        self::assertCount(3, $this->model->allowCountries);

        $this->model->allowCountries->each(function (VideoAllowedCountry $allowedCountry) {
            self::assertEquals($allowedCountry->getAttribute('video_id'), $this->model->getKey());
        });
    }

    /** @test */
    public function it_should_have_human_time_attribute(): void
    {
        $this->model->setAttribute('duration', 12300);
        self::assertEquals('03:25:00', $this->model->getAttribute('human_time'));
    }

    /** @test */
    public function it_should_have_list_of_hidden_attributes(): void
    {
        self::assertModelHasHiddenAttributes($this->model, [
            'storage_original_name'
        ]);
    }

    /** @test */
    public function it_should_have_tags_scope(): void
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        factory(get_class($this->model), 3)->create();

        $tags = factory(Tag::class, 4)
            ->create()
            ->pluck('id')
            ->toArray();

        $this->model->tags()->sync($tags);

        $result = $this->model->newQuery()->tags($tags)->first();

        self::assertEquals($this->model->getKey(), $result->getKey());
    }

    /** @test */
    public function it_should_have_categories_scope(): void
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        factory(get_class($this->model), 3)->create();

        $categories = factory(Category::class, 4)
            ->create()
            ->pluck('id')
            ->toArray();

        $this->model->categories()->sync($categories);

        $result = $this->model->newQuery()->categories($categories)->first();

        self::assertEquals(
            $this->model->getKey(),
            $result->getKey()
        );
    }

    /** @test */
    public function it_should_have_trailer_relation(): void
    {
        $video = factory(Video::class)->create();
        $this->model->trailers()->sync([$video->getKey() => ['title' => 'new title', 'order' => 1]]);
        $this->model->save();

        $this->model->trailers()->each(function (Video $tr) {
            self::assertEquals(
                $this->model->getKey(), $tr->pivot->getAttribute('video_id')
            );
        });

        self::assertCount(1, $this->model->trailers);
        self::assertModelRelationKeys($this->model->trailers(), 'video_id', 'trailer_id');
    }

    /** @test */
    public function it_should_have_category_trailer_relation()
    {
        $category = factory(Category::class, 4)->create();
        $this->model->categoryTrailer()->sync($category->pluck('id'));

        $this->model->categoryTrailer()->each(function (Category $cat) {
            self::assertEquals(
                $this->model->getKey(), $cat->pivot->getAttribute('video_id')
            );
        });

        self::assertCount(4, $this->model->categoryTrailer);
        self::assertModelRelationKeys($this->model->categoryTrailer(), 'video_id', 'category_id');
    }

    /** @test */
    public function it_should_have_custom_fields_relation()
    {
        $faker = Faker::create();
        $types = [
            'date' => [
                'date' => $faker->date(),
                'datetime' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            'string' => [
                'string' => $faker->word(),
                'select' => $faker->word(),
                'time' => $faker->time()
            ],
            'json' => [
                'select_multiple' => json_encode([['label' => 'label', 'value' => 'value']]),
                'link' => json_encode([['label' => 'label', 'value' => 'value']])
            ],
        ];

        $myCustomFields = [];
        foreach ($types as $valueType => $fieldTypes) {
            foreach ($fieldTypes as $type => $value) {
                $customField = factory(CustomField::class)->create();
                $customField->setAttribute('type', $type);

                $myCustomFields[$customField->getKey()] = [$customField->valueType => $value];
            }
        }
        $this->model->customFields()->sync($myCustomFields);

        self::assertCount(7, $this->model->customFields);
        self::assertCount(2, $this->model->customFields()->whereNotNull('date')->get());
        self::assertCount(3, $this->model->customFields()->whereNotNull('string')->get());
        self::assertCount(2, $this->model->customFields()->whereNotNull('json')->get());
        self::assertModelRelationKeys($this->model->customFields(), 'video_id', 'custom_field_id');
    }

    /** @test */
    public function it_should_transform_to_audit(): void
    {
        $tenant_id = '123123';
        $title = 'test-title';
        $this->model->setAttribute('tenant_id', $tenant_id);
        $this->model->setAttribute('title', $title);

        $result = $this->model->transformAudit([]);
        self::assertEquals([
            'tenant_id' => $tenant_id,
            'title' => $title
        ], $result);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
