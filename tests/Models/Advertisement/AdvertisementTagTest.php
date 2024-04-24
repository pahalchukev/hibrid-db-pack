<?php

namespace HibridVod\Database\Tests\Models\Advertisement;

use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Advertisement\AdvertisementTag;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;

class AdvertisementTagTest extends TestCase
{
    use DatabaseMigrations, HasDefaultRelationsAsserts;

    private AdvertisementTag $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(AdvertisementTag::class)->create();
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
            'type',
            'title',
            'tag',
            'tenant_id',
            'created_by',
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
