<?php

namespace HibridVod\Database\Tests\Models\Tag;

use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Traits\CustomHasTranslations;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Models\Traits\HasTenantId;
use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Tag\Tag;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;
use OwenIt\Auditing\Auditable as AuditableTrait;

class TagTest extends TestCase
{
    use DatabaseMigrations;

    private Tag $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(Tag::class)->create();
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
            'color',
            'title',
            'tenant_id',
            'category',
            'title_trans'
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            SoftDeletes::class,
            Uuidable::class,
            AuditableTrait::class,
            HasTenantId::class,
            ExtraEventsTrait::class,
            CustomHasTranslations::class
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
