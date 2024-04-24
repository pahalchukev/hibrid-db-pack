<?php

namespace HibridVod\Database\Tests\Models\Tenant;

use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\TenantStream\TenantStream;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

class TenantTest extends TestCase
{
    use DatabaseMigrations;

    private Tenant $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(Tenant::class)->create();
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
            'logo',
            'name',
            'alias',
            'favico',
            'config',
            'contact_information',
            'is_active',
            'secrets',
            'editor_seats',
            'live_stream_seats',
            'playout_seats',
        ]);
    }

    /** @test */
    public function it_should_have_list_of_hidden_attributes(): void
    {
        self::assertModelHasHiddenAttributes($this->model, [
            'config'
        ]);
    }

    /** @test */
    public function it_should_have_list_of_casts_attributes(): void
    {
        self::assertEquals([
            "contact_information" => "json",
            "secrets"             => "json",
            "config"              => "json",
        ], $this->model->getCasts());
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            Uuidable::class,
        ]);
    }

    /** @test */
    public function it_should_have_user_relation(): void
    {
        $this->model->users()->saveMany(
            [
                factory(User::class)->make(['username' => 'Nick']),
                factory(User::class)->make(['username' => 'Jack']),
            ]
        );

        self::assertEquals(2, $this->model->users()->get()->count());
        self::assertModelRelationKeys($this->model->users(), 'tenant_id');
    }

    /** @test */
    public function it_should_have_streams_relation(): void
    {
        $this->model->streams()->saveMany(
            factory(TenantStream::class, 3)->make()
        );

        self::assertCount(3, $this->model->streams);

        $this->model->streams->each(function (TenantStream $stream) {
            self::assertEquals($stream->getAttribute('tenant_id'), $this->model->getKey());
        });
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
