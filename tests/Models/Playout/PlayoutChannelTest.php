<?php

namespace HibridVod\Database\Tests\Models\Playout;

use HibridVod\Database\Models\Playout\PlayoutChannels;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Tests\TestCase;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

class PlayoutChannelTest extends TestCase
{
    use DatabaseMigrations;

    private PlayoutChannels $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(PlayoutChannels::class)->create();
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
