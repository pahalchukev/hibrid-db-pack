<?php

namespace HibridVod\Database\Tests\Models\Stream;

use HibridVod\Database\Models\Stream\DelayedStream;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Models\Traits\HasTenantId;
use HibridVod\Database\Tests\TestCase;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Stream\LiveStream;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;
use OwenIt\Auditing\Auditable as AuditableTrait;

class LiveStreamTest extends TestCase
{
    use DatabaseMigrations;

    private LiveStream $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(LiveStream::class)->create();
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
            'dvr_server_id',
            'dvr_server_ip',
            'dvr_id',
            'dvr_options',
            'nimble_secret',
            'tenant_id',
            'is_catchup',
            'max_editing_duration',
            'last_recording_time'
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            SoftDeletes::class,
            Uuidable::class,
            AuditableTrait::class,
            HasTenantId::class,
            ExtraEventsTrait::class
        ]);
    }

    /** @test */
    public function it_should_have_dvr_options_always_returning_object(): void
    {
        $this->model->setAttribute('dvr_options', null);

        self::assertEquals(
            new \stdClass(), $this->model->getAttribute('dvr_options')
        );
    }

    /** @test */
    public function it_should_have_stream_url_attribute(): void
    {
        self::assertEquals(
            "https://{$this->model->getAttribute('dvr_server_ip')}/{$this->model->getAttribute('dvr_options')->application}/{$this->model->getAttribute('dvr_options')->stream}/playlist.m3u8", $this->model->getAttribute('stream_url')
        );
    }

    /** @test */
    public function it_should_have_delayed_streams_relation(): void
    {
        $delayedStreams = factory(DelayedStream::class, 4)->create();
        $this->model->delayedStreams()->saveMany($delayedStreams);

        $this->model->delayedStreams->each(function (DelayedStream $delayedStream) {
            self::assertEquals(
                $this->model->getKey(), $delayedStream->getAttribute('stream_id')
            );
        });

        self::assertCount(4, $this->model->delayedStreams);
        self::assertModelRelationKeys($this->model->delayedStreams(), 'stream_id', 'id');
    }

    /** @test */
    public function it_should_have_tenant_relation(): void
    {
        self::assertInstanceOf(Tenant::class, $this->model->tenant);
        self::assertModelRelationKeys($this->model->tenant(), 'tenant_id');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
