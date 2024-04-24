<?php

namespace HibridVod\Database\Tests\Models\RemoteSync;

use HibridVod\Database\Tests\TestCase;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\RemoteSync\Connection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;

class ConnectionTest extends TestCase
{
    use DatabaseMigrations, HasDefaultRelationsAsserts;

    private Connection $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(Connection::class)->create();
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
            'name',
            'alias',
            'adapter',
            'created_by',
            'tenant_id',
            'is_enabled',
            'is_locked',
            'fetched_videos',
            'fetched_size',
            'last_connected_at',
            'adapter_config',
        ]);
    }

    /** @test */
    public function it_should_have_list_of_casts_attributes(): void
    {
        self::assertEquals([
            'adapter_config' => 'json',
        ], $this->model->getCasts());
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
    public function it_can_switch_is_locked_state(): void
    {
        $this->model->setAttribute('is_locked', true);
        $this->model->save();

        $this->model->switchIsLocked();
        $this->model->fresh();

        self::assertFalse($this->model->getAttribute('is_locked'));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
