<?php

namespace HibridVod\Database\Tests\Models\Translation;

use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Traits\HasTenantId;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Translation\TranslationLanguage;

class TranslationLanguageTest extends TestCase
{
    use DatabaseMigrations;

    private TranslationLanguage $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(TranslationLanguage::class)->create();
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
            'lang',
            'order',
            'tenant_id',
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            HasTenantId::class,
            Uuidable::class,
        ]);
    }

    /** @test */
    public function it_should_have_tenant_relation(): void
    {
        self::assertInstanceOf(Tenant::class, $this->model->tenant);
        self::assertModelRelationKeys($this->model->tenant(), 'tenant_id');
    }

    /** @test */
    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
