<?php

namespace HibridVod\Database\Tests\Models\Cast;

use HibridVod\Database\Models\Cast\Cast;
use HibridVod\Database\Models\Cast\CastPoster;
use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

class CastPosterTest extends TestCase
{
    use DatabaseMigrations;

    private CastPoster $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(CastPoster::class)->create();
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
            'cast_id',
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
    public function it_should_have_cast_relation(): void
    {
        self::assertInstanceOf(Cast::class, $this->model->cast);
        self::assertModelRelationKeys($this->model->cast(), 'cast_id');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
