<?php

namespace HibridVod\Database\Tests\Models\Subscription;

use HibridVod\Database\Tests\TestCase;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Subscription\Subscription;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;

class SubscriptionTest extends TestCase
{
    use DatabaseMigrations, HasDefaultRelationsAsserts;

    private Subscription $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(Subscription::class)->create();
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
            'created_by',
            'tenant_id',
            'title',
            'time',
            'price',
            'type',
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
