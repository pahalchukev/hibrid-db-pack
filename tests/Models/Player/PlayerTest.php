<?php

namespace HibridVod\Database\Tests\Models\Player;

use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Models\Traits\HasTenantId;
use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Player\Player;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Advertisement\AdvertisementTag;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PlayerTest extends TestCase
{
    use DatabaseMigrations, HasDefaultRelationsAsserts;

    private Player $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(Player::class)->create();
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
            'title',
            'type',
            'options',
            'is_default',
            'created_by',
            'tenant_id',

            'domain_status',
            'blocked_links',
            'allowed_links',

            'advertisement_tag_id'
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
            AuditableTrait::class,
            HasTenantId::class,
            ExtraEventsTrait::class
        ]);
    }

    /** @test */
    public function it_should_have_advertisement_tag_relation(): void
    {
        self::assertInstanceOf(AdvertisementTag::class, $this->model->advertisement);
        self::assertModelRelationKeys($this->model->advertisement(), 'advertisement_tag_id');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
