<?php

namespace HibridVod\Database\Tests\Models\User;

use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\User\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\User\UserInviteToken;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserInviteTokenTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var \HibridVod\Database\Models\User\UserInviteToken
     */
    private UserInviteToken $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(UserInviteToken::class)->create();
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
            'token',
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            SoftDeletes::class,
            Uuidable::class,
        ]);
    }

    /** @test */
    public function it_should_have_user_relation(): void
    {
        self::assertInstanceOf(User::class, $this->model->user);
        self::assertModelRelationKeys($this->model->user(), 'user_id');
    }

    /** @test */
    public function it_should_find_entry_by_token(): void
    {
        $new = $this->model->replicate(['token']);
        $new->setAttribute('token', 'new_token');
        $new->save();

        $result = $this->model->findByToken($new->token)->getKey();

        self::assertEquals($new->getKey(), $result);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
