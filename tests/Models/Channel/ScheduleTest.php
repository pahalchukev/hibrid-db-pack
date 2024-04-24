<?php

namespace HibridVod\Database\Tests\Models\Channel;

use HibridVod\Database\Models\Channel\Schedule;
use HibridVod\Database\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Traits\Uuidable;

class ScheduleTest extends  TestCase
{
    use DatabaseMigrations;

    private Schedule $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(Schedule::class)->create();
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
            'date',
            'start_time',
            'prime_time',
            'prime_time_fill',
            'prime_time_overlap',
            'prime_time_filler',
            'ad_breaks',
            'channel_id',
            'intro_id',
            'intro_duration',
            'outro_id',
            'outro_duration',
            'status',
            'message',
            'hls_history',
            'extra',
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            Uuidable::class,
            UsesSystemConnection::class,
            SoftDeletes::class,
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
