<?php

namespace HibridVod\Database\Tests\Models\RemoteSync;

use HibridVod\Database\Tests\TestCase;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\RemoteSync\SyncAudit;
use HibridVod\Database\Models\RemoteSync\Connection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

class SyncAuditsTest extends TestCase
{
    use DatabaseMigrations;

    private SyncAudit $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(SyncAudit::class)->create();
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
            'state',
            'context',
            'connection_id',
        ]);
    }

    /** @test */
    public function it_should_have_list_of_casts_attributes(): void
    {
        self::assertEquals([
            'context' => 'json',
        ], $this->model->getCasts());
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

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
