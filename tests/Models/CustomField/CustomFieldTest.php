<?php

namespace HibridVod\Database\Tests\Models\CustomField;

use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Tests\TestCase;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use HibridVod\Database\Models\Traits\HasTenantId;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Models\CustomField\CustomField;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;

class CustomFieldTest extends TestCase
{
    use DatabaseMigrations;

    private CustomField $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(CustomField::class)->create();
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
            'tenant_id',
            'type',
            'is_active',
            'label',
            'entity_type',
            'options',
            'slug',
            'order'
        ]);
    }

    /** @test */
    public function it_should_have_list_of_casts_attributes(): void
    {
        self::assertEquals([
            'is_active' => 'boolean',
            'options' => 'array'
        ], $this->model->getCasts());
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
        ]);
    }

    /** @test */
    public function it_should_have_tenant_relation(): void
    {
        self::assertInstanceOf(Tenant::class, $this->model->tenant);
        self::assertModelRelationKeys($this->model->tenant(), 'tenant_id');
    }

    /** @test */
    public function it_should_have_type_attribute()
    {
        $types = [
            'date' => [
                'date',
                'datetime',
            ],
            'string' => [
                'string',
                'select',
                'time',
                'translated_select'
            ],
            'json' => [
                'select_multiple',
                'link',
                'translated_select_multiple'
            ],
            'translation_json' => [
                'translated_string',
                'translated_text'
            ]
        ];

        foreach ($types as $valueType => $fieldTypes) {
            foreach ($fieldTypes as $type) {
                $this->model->setAttribute('type', $type);
                self::assertEquals($this->model->valueType, $valueType);
            }
        }
    }
}
