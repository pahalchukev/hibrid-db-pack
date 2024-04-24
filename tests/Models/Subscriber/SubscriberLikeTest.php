<?php

namespace HibridVod\Database\Tests\Models\Subscriber;

use HibridVod\Database\Models\Subscriber\Subscriber;
use HibridVod\Database\Models\Subscriber\SubscriberLike;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Tests\TestCase;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

class SubscriberLikeTest extends TestCase {

    use DatabaseMigrations;

    private SubscriberLike $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(SubscriberLike::class)->create();
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
            'subscriber_id',
            'video_id',
            'like'
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
        ]);
    }

    /** @test */
    public function it_should_have_subscriber_relation(): void
    {
        self::assertInstanceOf(Subscriber::class, $this->model->subscriber);
        self::assertModelRelationKeys($this->model->subscriber(), 'subscriber_id');
    }

    /** @test */
    public function it_should_have_video_relation(): void
    {
        self::assertInstanceOf(Video::class, $this->model->video);
        self::assertModelRelationKeys($this->model->video(), 'video_id');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}