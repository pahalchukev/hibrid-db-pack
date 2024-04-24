<?php

namespace HibridVod\Database\Tests\Models\User;

use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\User\Role;
use HibridVod\Database\Models\Tenant\Tenant;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\User\UserInviteToken;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var \HibridVod\Database\Models\User\User
     */
    private User $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(User::class)->create();
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
            'first_name',
            'last_name',
            'email',
            'username',
            'password',
            'tenant_id',
            'role_id',
            'two_factor_secret'
        ]);
    }

    /** @test */
    public function it_should_have_list_of_appended_attributes(): void
    {
        self::assertModelHasAppendedAttributes($this->model, [
            'full_name',
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
    public function it_should_have_role_relation(): void
    {
        self::assertInstanceOf(Role::class, $this->model->role);
        self::assertModelRelationKeys($this->model->role(), 'role_id');
    }

    /** @test */
    public function role_is_not_required_for_user(): void
    {
        $this->model->setAttribute('role_id', null);
        $this->model->save();

        self::assertNull($this->model->role);
    }

    /** @test */
    public function it_should_have_invite_token_relation(): void
    {
        $this->model->inviteToken()->save(
            factory(UserInviteToken::class)->make()
        );
        self::assertInstanceOf(UserInviteToken::class, $this->model->inviteToken->first());
        self::assertModelRelationKeys($this->model->inviteToken(), 'user_id');
    }

    /** @test */
    public function it_will_allow_any_permission_if_user_root(): void
    {
        $this->model->setAttribute('is_root', true);
        $this->model->save();

        $result = $this->model->checkPermissionTo('fake');
        self::assertTrue($result);
    }

    /** @test */
    public function it_can_check_permission_via_role(): void
    {
        $this->expectException(PermissionDoesNotExist::class);

        $this->model->checkPermissionTo('permission');
    }

    /** @test */
    public function it_should_have_full_name_accessor(): void
    {
        $this->model->first_name = 'john';
        $this->model->last_name = 'travolta';

        self::assertEquals('john travolta', $this->model->getAttribute('full_name'));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
