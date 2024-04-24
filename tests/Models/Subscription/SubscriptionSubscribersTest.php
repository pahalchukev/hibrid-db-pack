<?php

namespace HibridVod\Database\Tests\Models\Subscription;

use HibridVod\Database\Models\Subscription\Subscription;
use HibridVod\Database\Models\Subscription\SubscriptionSubscriber;
use HibridVod\Database\Models\Tenant\ApiClient;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;

class SubscriptionSubscribersTest extends TestCase
{
    use DatabaseMigrations;

    private SubscriptionSubscriber $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(SubscriptionSubscriber::class)->create();
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
            'subscription_id',
            'subscriber_id',
            'price',
            'type',
            'tenant_id',
            'api_client_id',
            'created_at',
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            Uuidable::class
        ]);
    }

    /** @test */
    public function it_should_have_api_client_relation(): void
    {
        self::assertInstanceOf(ApiClient::class, $this->model->apiClient);
        self::assertModelRelationKeys($this->model->apiClient(), 'api_client_id');
    }

    /** @test */
    public function it_should_have_subscription_relation(): void
    {
        self::assertInstanceOf(Subscription::class, $this->model->subscription);
        self::assertModelRelationKeys($this->model->subscription(), 'subscription_id');
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
