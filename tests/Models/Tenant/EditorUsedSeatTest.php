<?php

namespace HibridVod\Database\Tests\Models\Tenant;

use HibridVod\Database\Models\Video\RemoteVideo;
use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Tenant\EditorUsedSeat;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

class EditorUsedSeatTest extends TestCase
{
    use DatabaseMigrations;

    private EditorUsedSeat $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(EditorUsedSeat::class)->create();
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
            'tenant_id',
            'video_id',
            'user_id',
            'is_active',
            'remote_video_id'
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
        ]);
    }

    /** @test */
    public function it_should_have_user_relation(): void
    {
        self::assertInstanceOf(User::class, $this->model->user);
        self::assertModelRelationKeys($this->model->user(), 'user_id');
    }

    /** @test */
    public function it_should_have_tenant_relation(): void
    {
        self::assertInstanceOf(Tenant::class, $this->model->tenant);
        self::assertModelRelationKeys($this->model->tenant(), 'tenant_id');
    }

    /** @test */
    public function it_should_have_video_relation(): void
    {
        self::assertInstanceOf(Video::class, $this->model->video);
        self::assertModelRelationKeys($this->model->video(), 'video_id');
    }

    /** @test */
    public function it_could_have_remote_video_relation(): void
    {
        self::assertInstanceOf(RemoteVideo::class, $this->model->remoteVideo);
        self::assertModelRelationKeys($this->model->remoteVideo(), 'remote_video_id');
    }
}
