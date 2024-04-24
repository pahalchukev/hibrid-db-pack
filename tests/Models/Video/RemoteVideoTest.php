<?php

namespace HibridVod\Database\Tests\Models\Video;

use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Models\Tenant\Tenant;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Tenant\ApiClient;
use HibridVod\Database\Models\Video\RemoteVideo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use OwenIt\Auditing\Auditable as AuditableTrait;

class RemoteVideoTest extends TestCase
{
    use DatabaseMigrations;

    private RemoteVideo $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(RemoteVideo::class)->create();
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
            'title',
            'description',
            'video_url',
            'webhook_url',
            'should_activate',
            'tags_ids',
            'should_activate',
            'tenant_id',
            'video_id',
            'api_client_id',
            'processed_at',
            'reference_id',
            'priority',
            'fetched_at',
            'download_from',
            'parent_video_id'
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            Uuidable::class,
            AuditableTrait::class
        ]);
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
    public function it_should_have_api_client_relation(): void
    {
        self::assertInstanceOf(ApiClient::class, $this->model->apiClient);
        self::assertModelRelationKeys($this->model->apiClient(), 'api_client_id');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
