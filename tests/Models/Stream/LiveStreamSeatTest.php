<?php

namespace HibridVod\Database\Tests\Models\Stream;

use HibridVod\Database\Models\Video\RemoteVideo;
use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Stream\LiveStreamSeat;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;

class LiveStreamSeatTest extends TestCase
{
    use DatabaseMigrations, HasDefaultRelationsAsserts;

    private LiveStreamSeat $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(LiveStreamSeat::class)->create();
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
            'stream_id',
            'created_by',
            'tenant_id',
            'is_active',
            'start_timestamp',
            'end_timestamp',
            'remote_video_id'
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            HasDefaultRelations::class,
            Uuidable::class,
        ]);
    }

    /** @test */
    public function it_should_have_delayed_streams_relation(): void
    {
        self::assertEquals($this->model->liveStream->getKey(), $this->model->getAttribute('stream_id'));
    }

    /** @test */
    public function it_could_have_remote_video_relation(): void
    {
        self::assertInstanceOf(RemoteVideo::class, $this->model->remoteVideo);
        self::assertModelRelationKeys($this->model->remoteVideo(), 'remote_video_id');
    }
}
