<?php

namespace HibridVod\Database\Tests\Models\Subscriber;

use HibridVod\Database\Tests\TestCase;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Subscriber\Subscriber;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Subscription\Subscription;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Subscriber\SubscriberSubscription;

class SubscriberSubscriptionTest extends TestCase {

    use DatabaseMigrations;

    private SubscriberSubscription $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(SubscriberSubscription::class)->create();
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
            'subscriber_id',
            'subscription_id',
            'price',
            'type',
            'expiring_at',
            'expired_at'
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
    public function it_should_have_subscriber_relation(): void
    {
        self::assertInstanceOf(Subscriber::class, $this->model->subscriber);
        self::assertModelRelationKeys($this->model->subscriber(), 'subscriber_id');
    }

    /** @test */
    public function it_should_have_subscription_relation(): void
    {
        self::assertInstanceOf(Subscription::class, $this->model->subscription);
        self::assertModelRelationKeys($this->model->subscription(), 'subscription_id');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}