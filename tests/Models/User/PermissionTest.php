<?php

namespace HibridVod\Database\Tests\Models\User;

use HibridVod\Database\Tests\TestCase;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\User\Permission;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

class PermissionTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var \HibridVod\Database\Models\User\Permission
     */
    private Permission $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(Permission::class)->create();
    }

    /** @test */
    public function it_should_use_system_connection(): void
    {
        self::assertHasSystemConnection($this->model);
    }

    /** @test */
    public function it_should_have_fillable_attributes(): void
    {
        self::assertModelHasFillableColumns($this->model, [
            'name',
            'group',
            'guard_name',
            'service'
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            SoftDeletes::class,
        ]);
    }

    /** @test */
    public function it_can_find_permission_by_name_and_guard(): void
    {
        /** @example `videos.view`, `users.delete` */
        $result = Permission::findByName(
            sprintf('%s.%s', $this->model->getAttribute('group'), $this->model->getAttribute('name')),
            $this->model->getAttribute('guard_name')
        );

        self::assertInstanceOf(Permission::class, $result);
    }

    /** @test */
    public function it_can_throw_exception_if_permission_not_found_by_name(): void
    {
        $this->expectException(PermissionDoesNotExist::class);

        Permission::findByName($this->model->getAttribute('name'));
    }

    /** @test */
    public function it_can_create_new_permission(): void
    {
        $result = Permission::create([
            'name'  => 'delete',
            'group' => 'users',
        ]);
        self::assertInstanceOf(Permission::class, $result);
    }

    /** @test */
    public function it_will_throw_exception_if_permission_already_exist(): void
    {
        $this->expectException(PermissionAlreadyExists::class);

        Permission::create([
            'name'  => $this->model->getAttribute('name'),
            'group' => $this->model->getAttribute('group'),
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
