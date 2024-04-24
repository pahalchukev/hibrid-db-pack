<?php

namespace HibridVod\Database\Tests\Models\Traits;

use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;

/**
 * Trait HasDefaultRelationsAsserts
 * @package HibridVod\Database\Tests\Models\Traits
 * @property-read $model
 * @mixin \HibridVod\Database\Tests\TestCase
 */
trait HasDefaultRelationsAsserts
{
    /** @test */
    public function it_should_have_created_by_relation(): void
    {
        self::assertInstanceOf(User::class, $this->model->createdBy);
        self::assertModelRelationKeys($this->model->createdBy(), 'created_by');
    }

    /** @test */
    public function it_should_have_tenant_relation(): void
    {
        self::assertInstanceOf(Tenant::class, $this->model->tenant);
        self::assertModelRelationKeys($this->model->tenant(), 'tenant_id');
    }
}
