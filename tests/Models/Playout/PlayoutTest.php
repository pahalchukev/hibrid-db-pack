<?php

namespace HibridVod\Database\Tests\Models\Playout;

use HibridVod\Database\Models\Playout\Playout;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

class PlayoutTest extends TestCase
{
    use DatabaseMigrations;

    private Playout $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(Playout::class)->create();
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
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            Uuidable::class,
            ExtraEventsTrait::class,
        ]);
    }
}
