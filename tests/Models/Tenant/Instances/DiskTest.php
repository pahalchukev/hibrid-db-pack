<?php

namespace HibridVod\Database\Tests\Models\Tenant\Instances;

use HibridVod\Database\Models\Tenant\Instances\Disk;
use HibridVod\Database\Tests\TestCase;

class DiskTest extends TestCase
{
    private Disk $instance;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = new Disk(Disk::DEFAULT_TYPE);
    }

    /** @test */
    public function it_should_have_the_same_type(): void
    {
        self::assertTrue($this->instance->is(Disk::DEFAULT_TYPE));
    }

    /** @test */
    public function it_should_have_not_the_same_type(): void
    {
        self::assertFalse($this->instance->is('product'));
    }
}
