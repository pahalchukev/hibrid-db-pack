<?php

namespace HibridVod\Database\Tests\Models\ConvertQueuedVideo;

use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\ConvertQueuedVideo\ConvertQueuedVideo;

class ConvertQueuedVideoTest extends TestCase
{
    use DatabaseMigrations;

    private ConvertQueuedVideo $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(ConvertQueuedVideo::class)->create();
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
            'video_id',
            'tenant_id',
            'converted_at',
            'failed_at',
            'failed_exception',
            'is_converting',
            'is_downloading',
            'is_storing',
            'downloaded_at',
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            Uuidable::class,
        ]);
    }
}
