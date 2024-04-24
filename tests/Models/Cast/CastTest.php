<?php

namespace HibridVod\Database\Tests\Models\Cast;

use HibridVod\Database\Models\Cast\Cast;
use HibridVod\Database\Models\Cast\CastPoster;
use HibridVod\Database\Models\Category\Category;
use HibridVod\Database\Models\Playlist\Playlist;
use HibridVod\Database\Models\Traits\CustomHasTranslations;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Tests\TestCase;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

class CastTest extends TestCase
{
    use DatabaseMigrations;

    private Cast $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(Cast::class)->create();
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
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            SoftDeletes::class,
            Uuidable::class,
            ExtraEventsTrait::class,
            HasDefaultRelations::class,
            CustomHasTranslations::class
        ]);
    }

    /** @test */
    public function it_should_have_posters_relation(): void
    {
        $this->model->posters()->saveMany(
            factory(CastPoster::class, 3)->make()
        );

        self::assertCount(3, $this->model->posters);

        $this->model->posters->each(function (CastPoster $poster) {
            self::assertEquals($poster->getAttribute('cast_id'), $this->model->getKey());
        });
    }

    /** @test */
    public function it_should_have_videos_relation(): void
    {
        $videos = factory(Video::class, 4)->create();
        $this->model->videos()->sync($videos->pluck('id'));

        $this->model->videos->each(function (Video $video) {
            self::assertEquals(
                $this->model->getKey(), $video->pivot->getAttribute('cast_id')
            );
        });

        self::assertCount(4, $this->model->videos);
        self::assertModelRelationKeys($this->model->videos(), 'cast_id', 'video_id');
    }

    /** @test */
    public function it_should_have_categories_relation(): void
    {
        $categories = factory(Category::class, 4)->create();
        $this->model->categories()->sync($categories->pluck('id'));

        $this->model->categories->each(function (Category $category) {
            self::assertEquals(
                $this->model->getKey(), $category->pivot->getAttribute('cast_id')
            );
        });

        self::assertCount(4, $this->model->categories);
        self::assertModelRelationKeys($this->model->categories(), 'cast_id', 'category_id');
    }
    /** @test */
    public function it_should_have_playlists_relation(): void
    {
        $playlists = factory(Playlist::class, 4)->create();
        $this->model->playlists()->sync($playlists->pluck('id'));

        $this->model->playlists->each(function (Playlist $playlist) {
            self::assertEquals(
                $this->model->getKey(), $playlist->pivot->getAttribute('cast_id')
            );
        });

        self::assertCount(4, $this->model->playlists);
        self::assertModelRelationKeys($this->model->playlists(), 'cast_id', 'playlist_id');
    }
    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
