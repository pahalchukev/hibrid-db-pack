<?php

namespace HibridVod\Database\Tests\Models\Subscriber;

use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Tenant\Tenant;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Tenant\ApiClient;
use HibridVod\Database\Models\Subscriber\Subscriber;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

class SubscriberTest extends TestCase {

    use DatabaseMigrations;

    private Subscriber $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(Subscriber::class)->create();
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
            'first_name',
            'last_name',
            'balance',
            'meta_data',
            'status',
            'tenant_id',
            'api_client_id',
            'username',
            'email',
            'phone',
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
    public function it_should_have_api_client_relation(): void
    {
        self::assertInstanceOf(ApiClient::class, $this->model->apiClient);
        self::assertModelRelationKeys($this->model->apiClient(), 'api_client_id');
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