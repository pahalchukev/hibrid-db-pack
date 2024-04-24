<?php

namespace HibridVod\Database\Tests\Models\User;

use HibridVod\Database\Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use HibridVod\Database\Models\User\Role;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

class RoleTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var \HibridVod\Database\Models\User\Role
     */
    private Role $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(Role::class)->create();
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
            'name',
            'guard_name',
            'is_reserved',
            'tenant_id',
            'services'
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            SoftDeletes::class,
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
    public function it_should_have_active_users_relation(): void
    {
        $this->model->activeUsers()->save(
            factory(User::class)->make()
        );

        self::assertInstanceOf(User::class, $this->model->activeUsers()->first());
        self::assertModelRelationKeys($this->model->activeUsers(), 'role_id');
    }

    /** @test */
    public function it_can_find_role_by_name_and_guard(): void
    {
        $result = Role::findByName(
            $this->model->getAttribute('name'),
            $this->model->getAttribute('guard_name')
        );

        self::assertInstanceOf(Role::class, $result);
    }

    /** @test */
    public function it_can_throw_exception_if_role_not_found_by_name(): void
    {
        $this->expectException(RoleDoesNotExist::class);

        Role::findByName($this->model->getAttribute('name'));
    }

    /** @test */
    public function it_can_check_permission_by_it_id(): void
    {
        $permission = $this->mockPermission();

        self::assertTrue($this->model->hasPermissionTo($permission->id));
    }

    /** @test */
    public function it_can_check_permission_by_it_name(): void
    {
        $permission = $this->mockPermission();

        self::assertTrue($this->model->hasPermissionTo($permission->name));
    }

    /** @test */
    public function it_will_throw_exception_if_guard_mismatch(): void
    {
        $this->expectException(PermissionDoesNotExist::class);

        $permission = $this->mockPermission([
            'guard_name' => 'different',
            'name'       => 'test_name',
        ]);

        self::assertTrue($this->model->hasPermissionTo($permission->name));
    }

    /** @test */
    public function it_will_create_role_if_its_not_exist(): void
    {
        $result = Role::create([
            'tenant_id' => 1,
            'name'      => 'role',
        ]);

        self::assertEquals(1, $result->getAttribute('tenant_id'));
    }

    /** @test */
    public function it_will_throw_exception_if_role_exist_for_tenant(): void
    {
        $this->expectException(RoleAlreadyExists::class);
        Role::create([
            'tenant_id' => 1,
            'name'      => 'name',
        ]);
        Role::create([
            'tenant_id' => 1,
            'name'      => 'name',
        ]);
    }

    /** @test */
    public function it_not_throw_exception_if_role_exist_for_different_tenant(): void
    {
        $this->expectNotToPerformAssertions();

        Role::create([
            'tenant_id' => 1,
            'name'      => 'name',
        ]);
        Role::create([
            'tenant_id' => 2,
            'name'      => 'name',
        ]);
    }

    /**
     * @param array $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function mockPermission(array $attributes = []): Model
    {
        return $this->model->permissions()->create(array_merge([
            'name'       => 'view',
            'group'      => 'videos',
            'guard_name' => $this->model->getAttribute('guard_name'),
        ], $attributes));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
