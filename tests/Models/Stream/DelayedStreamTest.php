<?php

namespace HibridVod\Database\Tests\Models\Stream;

use HibridVod\Database\Models\Stream\DelayedStreamSchedule;
use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Traits\Uuidable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use HibridVod\Database\Models\Traits\HasTenantId;
use HibridVod\Database\Models\Stream\DelayedStream;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;

class DelayedStreamTest extends TestCase
{
    use DatabaseMigrations, HasDefaultRelationsAsserts;

    private DelayedStream $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(DelayedStream::class)->create();
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
            'title',
            'recording_type',
            'selected_days',
            'start_at',
            'stop_at',
            'stop_recording'
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            HasDefaultRelations::class,
            Uuidable::class,
            AuditableTrait::class,
            HasTenantId::class
        ]);
    }

    /** @test */
    public function it_should_belongs_to_live_stream(): void
    {
        self::assertEquals($this->model->liveStream->getKey(), $this->model->getAttribute('stream_id'));
    }

    /** @test */
    public function it_should_have_many_delayed_schedules(): void
    {
        $schedules = factory(DelayedStreamSchedule::class, 2)->create();
        $this->model->schedules()->saveMany($schedules);

        $this->model->schedules->each(function (DelayedStreamSchedule $schedule) {
            self::assertEquals(
                $this->model->getKey(), $schedule->getAttribute('delayed_stream_id')
            );
        });

        self::assertCount(2, $this->model->schedules);
        self::assertModelRelationKeys($this->model->schedules(), 'delayed_stream_id', 'id');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
