<?php

namespace HibridVod\Database\Tests\Models\Playlist;

use HibridVod\Database\Models\Cast\Cast;
use HibridVod\Database\Models\Category\Category;
use HibridVod\Database\Models\Traits\CustomHasTranslations;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Models\Traits\HasTenantId;
use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Tag\Tag;
use HibridVod\Database\Models\Video\Video;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Playlist\Playlist;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PlaylistTest extends TestCase
{
    use DatabaseMigrations, HasDefaultRelationsAsserts;

    private Playlist $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(Playlist::class)->create();
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
            'reference_id',
            'title',
            'description',
            'thumbnail',
            'is_active',
            'created_by',
            'tenant_id',
            'title_trans',
            'description_trans'
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            CustomHasTranslations::class,
            UsesSystemConnection::class,
            HasDefaultRelations::class,
            SoftDeletes::class,
            Uuidable::class,
            AuditableTrait::class,
            HasTenantId::class,
            ExtraEventsTrait::class
        ]);
    }

    /** @test */
    public function it_should_have_videos_relation(): void
    {
        $tags = factory(Video::class, 4)->create();
        $this->model->videos()->sync($tags->pluck('id'));

        $this->model->videos->each(function (Video $tag) {
            self::assertEquals(
                $this->model->getKey(), $tag->pivot->getAttribute('playlist_id')
            );
        });

        self::assertCount(4, $this->model->videos);
        self::assertModelRelationKeys($this->model->videos(), 'playlist_id', 'video_id');
    }

    /** @test */
    public function it_should_have_casts_relation(): void
    {
        $casts = factory(Cast::class, 4)->create();
        $this->model->casts()->sync($casts->pluck('id'));

        $this->model->casts->each(function (Cast $cast) {
            self::assertEquals(
                $this->model->getKey(), $cast->pivot->getAttribute('playlist_id')
            );
        });

        self::assertCount(4, $this->model->casts);
        self::assertModelRelationKeys($this->model->casts(), 'playlist_id', 'cast_id');
    }

    /** @test */
    public function it_should_have_tags_relation(): void
    {
        $tags = factory(Tag::class, 4)->create();
        $this->model->tags()->sync($tags->pluck('id'));

        $this->model->tags->each(function (Tag $tag) {
            self::assertEquals(
                $this->model->getKey(), $tag->pivot->getAttribute('playlist_id')
            );
        });

        self::assertCount(4, $this->model->tags);
        self::assertModelRelationKeys($this->model->tags(), 'playlist_id', 'tag_id');
    }

    /** @test */
    public function it_should_have_categories_relation(): void
    {
        $categories = factory(Category::class, 4)->create();
        $this->model->categories()->sync($categories->pluck('id'));

        $this->model->tags->each(function (Category $categories) {
            self::assertEquals(
                $this->model->getKey(), $categories->pivot->getAttribute('playlist_id')
            );
        });

        self::assertCount(4, $this->model->categories);
        self::assertModelRelationKeys($this->model->categories(), 'playlist_id', 'category_id');
    }

    /** @test */
    public function it_should_have_trailers_relation(): void
    {
        $videos = factory(Video::class, 2)->create();
        $this->model->trailers()->sync($videos->pluck('id'));

        $this->model->trailers->each(function (Video $video) {
            self::assertEquals(
                $this->model->getKey(), $video->pivot->getAttribute('playlist_id')
            );
        });

        self::assertCount(2, $this->model->trailers);
        self::assertModelRelationKeys($this->model->trailers(), 'playlist_id', 'video_id');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
