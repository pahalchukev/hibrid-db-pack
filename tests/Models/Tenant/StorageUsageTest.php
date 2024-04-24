<?php

namespace HibridVod\Database\Tests\Models\Tenant;

use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Tenant\StorageUsage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

class StorageUsageTest extends TestCase
{
    use DatabaseMigrations;

    private StorageUsage $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(StorageUsage::class)->create();
    }

    /** @test */
    public function it_should_use_system_connection(): void
    {
        self::assertHasSystemConnection($this->model);
    }

    /** @test */
    public function it_should_have_fillable_attributes(): void
    {
        self::assertModelHasFillableColumns($this->model, [
            'used',
            'tenant_id',
            'filled_at',
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
        ]);
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
