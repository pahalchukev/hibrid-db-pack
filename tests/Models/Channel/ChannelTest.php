<?php

namespace HibridVod\Database\Tests\Models\Channel;

use HibridVod\Database\Models\Cast\Cast;
use HibridVod\Database\Models\Category\Category;
use HibridVod\Database\Models\Channel\Channel;
use HibridVod\Database\Models\Pivot\ChannelBreakVideo;
use HibridVod\Database\Models\Tag\Tag;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\HasTenantId;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;
use HibridVod\Database\Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ChannelTest extends TestCase
{
    use DatabaseMigrations, HasDefaultRelationsAsserts;

    private Channel $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(Channel::class)->create();
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
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            HasDefaultRelations::class,
            SoftDeletes::class,
            Uuidable::class,
            AuditableTrait::class,
            ExtraEventsTrait::class,
            HasTenantId::class,
        ]);
    }

    /** @test */
    public function it_should_have_tags_relation(): void
    {
        $tags = factory(Tag::class, 4)->create();
        $this->model->tags()->sync($tags->pluck('id'));

        $this->model->tags->each(function (Tag $tag) {
            self::assertEquals(
                $this->model->getKey(), $tag->pivot->getAttribute('channel_id')
            );
        });

        self::assertCount(4, $this->model->tags);
        self::assertModelRelationKeys($this->model->tags(), 'channel_id', 'tag_id');
    }

    /** @test */
    public function it_should_have_casts_relation(): void
    {
        $casts = factory(Cast::class, 4)->create();
        $this->model->casts()->sync($casts->pluck('id'));

        $this->model->casts->each(function (Cast $cast) {
            self::assertEquals(
                $this->model->getKey(), $cast->pivot->getAttribute('channel_id')
            );
        });

        self::assertCount(4, $this->model->casts);
        self::assertModelRelationKeys($this->model->casts(), 'channel_id', 'cast_id');
    }

    /** @test */
    public function it_should_have_categories_relation(): void
    {
        $categories = factory(Category::class, 4)->create();
        $this->model->categories()->sync($categories->pluck('id'));

        $this->model->tags->each(function (Category $categories) {
            self::assertEquals(
                $this->model->getKey(), $categories->pivot->getAttribute('channel_id')
            );
        });

        self::assertCount(4, $this->model->categories);
        self::assertModelRelationKeys($this->model->categories(), 'channel_id', 'category_id');
    }

    /** @test */
    public function it_should_have_break_fillers_relation(): void
    {
        $breakVideo = factory(ChannelBreakVideo::class)->create(['channel_id' => $this->model->getKey(), 'video_id'=>fn() => factory(Video::class)->create()]);
        $this->assertInstanceOf(HasMany::class, $this->model->breakFillers());
        $this->assertEquals($this->model->getKey(), $breakVideo->channel_id);
    }
    /** @test */
    public function it_should_have_intro_fillers_relation(): void
    {
        $breakVideo = factory(ChannelBreakVideo::class)->create(['channel_id' => $this->model->getKey(), 'intro_id'=>fn() => factory(Video::class)->create()]);
        $this->assertInstanceOf(HasMany::class, $this->model->introFillers());
        $this->assertEquals($this->model->getKey(), $breakVideo->channel_id);
    }
    /** @test */
    public function it_should_have_outro_fillers_relation(): void
    {
        $breakVideo = factory(ChannelBreakVideo::class)->create(['channel_id' => $this->model->getKey(), 'outro_id'=>fn() => factory(Video::class)->create()]);
        $this->assertInstanceOf(HasMany::class, $this->model->outroFillers());
        $this->assertEquals($this->model->getKey(), $breakVideo->channel_id);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
