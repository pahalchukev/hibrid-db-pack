<?php

namespace HibridVod\Database\Tests\Models\Category;

use HibridVod\Database\Models\Cast\Cast;
use HibridVod\Database\Models\Playlist\Playlist;
use HibridVod\Database\Models\Tag\Tag;
use HibridVod\Database\Models\Traits\CustomHasTranslations;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Category\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;

class CategoryTest extends TestCase
{
    use DatabaseMigrations, HasDefaultRelationsAsserts;

    private Category $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(Category::class)->create();
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
            'title',
            'created_by',
            'tenant_id',
            'parent_id',
            'reference_id',
            'description',
            'image',
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
        ]);
    }

    /** @test */
    public function it_should_have_child_categories_relation(): void
    {
        $this->model->childCategories()->saveMany(
            factory(Category::class, 4)->make([
                'parent_id' => $this->model->getKey(),
            ])
        );

        $this->model->childCategories()
            ->each(function (Category $category) {
                self::assertEquals($this->model->getKey(), $category->getAttribute('parent_id'));
            });

        self::assertInstanceOf(Collection::class, $this->model->childCategories);
        self::assertCount(4, $this->model->childCategories);
        self::assertModelRelationKeys($this->model->childCategories(), 'parent_id');
    }


    /** @test */
    public function it_should_have_casts_relation(): void
    {
        $casts = factory(Cast::class, 4)->create();
        $this->model->casts()->sync($casts->pluck('id'));

        $this->model->casts->each(function (Cast $cast) {
            self::assertEquals(
                $this->model->getKey(), $cast->pivot->getAttribute('category_id')
            );
        });

        self::assertCount(4, $this->model->casts);
        self::assertModelRelationKeys($this->model->casts(), 'category_id', 'cast_id');
    }

    /** @test */
    public function it_should_have_playlists_relation(): void
    {
        $playlists = factory(Playlist::class, 4)->create();
        $this->model->playlists()->sync($playlists->pluck('id'));

        $this->model->playlists->each(function (Playlist $playlists) {
            self::assertEquals(
                $this->model->getKey(), $playlists->pivot->getAttribute('category_id')
            );
        });

        self::assertCount(4, $this->model->playlists);
        self::assertModelRelationKeys($this->model->playlists(),'category_id','playlist_id');
    }

    /** @test */
    public function it_should_have_tags_relation(): void
    {
        $tags = factory(Tag::class, 4)->create();
        $this->model->tags()->sync($tags->pluck('id'));

        $this->model->tags->each(function (Tag $tag) {
            self::assertEquals(
                $this->model->getKey(), $tag->pivot->getAttribute('category_id')
            );
        });

        self::assertCount(4, $this->model->tags);
        self::assertModelRelationKeys($this->model->tags(), 'category_id', 'tag_id');
    }

    /** @test */
    public function it_should_have_trailers_relation(): void
    {
        $videos = factory(Video::class, 2)->create();
        $this->model->trailers()->sync($videos->pluck('id'));

        $this->model->trailers->each(function (Video $video) {
            self::assertEquals(
                $this->model->getKey(), $video->pivot->getAttribute('category_id')
            );
        });

        self::assertCount(2, $this->model->trailers);
        self::assertModelRelationKeys($this->model->trailers(), 'category_id', 'video_id');
    }

    /** @test */
    public function it_should_have_scope_root_only(): void
    {
        factory(get_class($this->model))->create([
            'parent_id' => $this->model->getKey()
        ]);

        $result = $this->model->rootOnly()->count();

        self::assertEquals(1, $result);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
