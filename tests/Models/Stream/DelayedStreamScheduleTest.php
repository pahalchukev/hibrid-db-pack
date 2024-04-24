<?php

namespace HibridVod\Database\Tests\Models\Stream;

use HibridVod\Database\Models\Stream\DelayedStreamSchedule;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;
use HibridVod\Database\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DelayedStreamScheduleTest extends TestCase
{
    use DatabaseMigrations;

    private DelayedStreamSchedule $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(DelayedStreamSchedule::class)->create();
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
            'delayed_stream_id',
            'command',
            'execute_at',
            'executed_at',
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            Uuidable::class,
        ]);
    }

    /** @test */
    public function it_should_belongs_to_delayed_stream(): void
    {
        self::assertEquals($this->model->delayedStream->getKey(), $this->model->getAttribute('delayed_stream_id'));
    }

    /** @test */
    public function it_should_belongs_to_live_stream(): void
    {
        self::assertEquals($this->model->stream->getKey(), $this->model->getAttribute('stream_id'));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
