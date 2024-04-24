<?php

namespace HibridVod\Database\Tests\Models\Tenant\Instances;

use HibridVod\Database\Models\Tenant\Instances\Config;
use HibridVod\Database\Models\Tenant\Instances\Disk;
use HibridVod\Database\Tests\TestCase;

class ConfigTest extends TestCase
{
    /** @test */
    public function it_should_have_default_values_if_input_config_params_is_empty(): void
    {
        $config = new Config();
        $disk = $config->getDisk();

        self::assertEquals(Disk::DEFAULT_TYPE, $disk->getType());
        self::assertEquals([], $disk->getKeys());
        self::assertEquals(config('app.url'), $config->getOriginUrl());
    }

    /** @test */
    public function it_should_have_the_same_values_as_the_input_config_params(): void
    {
        $config = new Config(['origin_url' => 'https://custom.url.com', 'disk' => ['type' => 'product', 'keys' => ['t1', 'y4']]]);
        $disk = $config->getDisk();

        self::assertEquals('product', $disk->getType());
        self::assertEquals(['t1', 'y4'], $disk->getKeys());
        self::assertEquals('https://custom.url.com', $config->getOriginUrl());
    }
}
