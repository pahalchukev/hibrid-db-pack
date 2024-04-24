<?php

namespace HibridVod\Database\Tests;

use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Category\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Class TestSeederClass
 * @package HibridVod\Database\Tests
 */
class TestSeederClass extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_should_seed_database_with_defaults(): void
    {
        $this->expectNotToPerformAssertions();

        $tenant = factory(Tenant::class)->create();
        $user = factory(User::class)->create([
            'tenant_id' => $tenant->id,
        ]);

        $category = factory(Category::class)->create([
            'tenant_id'  => $tenant->id,
            'created_by' => $user->id,
        ]);
    }
}
