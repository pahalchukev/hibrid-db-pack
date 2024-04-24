<?php

namespace HibridVod\Database\Tests\Models\RemoteSync;

use HibridVod\Database\Models\Video\RemoteVideo;
use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Tenant\Tenant;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\RemoteSync\Connection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\RemoteSync\SynchronizedVideo;

class SynchronizedVideosTest extends TestCase
{
    use DatabaseMigrations;

    private SynchronizedVideo $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(SynchronizedVideo::class)->create();
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
            'full_path',
            'path',
            'size',
            'extension',
            'file_name',
            'last_modified',
            'video_id',
            'remote_video_id',
            'connection_id',
            'tenant_id',
            'reference_id',
            'converted_at',
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            SoftDeletes::class,
            Uuidable::class,
        ]);
    }

    /** @test */
    public function it_should_have_connections_relation(): void
    {
        self::assertInstanceOf(Connection::class, $this->model->connection);
        self::assertModelRelationKeys($this->model->connection(), 'connection_id');
    }

    /** @test */
    public function it_should_have_tenant_relation(): void
    {
        self::assertInstanceOf(Tenant::class, $this->model->tenant);
        self::assertModelRelationKeys($this->model->tenant(), 'tenant_id');
    }

    /** @test */
    public function it_should_remote_video_relation(): void
    {
        self::assertInstanceOf(RemoteVideo::class, $this->model->remoteVideo);
        self::assertModelRelationKeys($this->model->remoteVideo(), 'remote_video_id');
    }


    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
