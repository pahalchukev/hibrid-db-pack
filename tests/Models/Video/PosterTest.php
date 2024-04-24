<?php

namespace HibridVod\Database\Tests\Models\Video;

use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Models\Video\Poster;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

class PosterTest extends TestCase
{
    use DatabaseMigrations;

    private Poster $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(Poster::class)->create();
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
            'dimensions',
            'path',
            'url',
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

    /** @test */
    public function it_should_have_video_relation(): void
    {
        self::assertInstanceOf(Video::class, $this->model->video);
        self::assertModelRelationKeys($this->model->video(), 'video_id');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
