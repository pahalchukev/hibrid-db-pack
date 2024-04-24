<?php

namespace HibridVod\Database\Tests\Models\Tenant;

use HibridVod\Database\Tests\TestCase;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Tenant\ApiClient;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;

class ApiClientTest extends TestCase
{
    use DatabaseMigrations, HasDefaultRelationsAsserts;

    private ApiClient $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(ApiClient::class)->create();
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
            'client_id',
            'access_token',
            'created_by',
            'tenant_id',
            'is_active',
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

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
