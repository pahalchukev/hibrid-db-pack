<?php

namespace HibridVod\Database\Models\Tenant\Instances;

use Illuminate\Support\Arr;

final class Config
{
    /**
     * @var \HibridVod\Database\Models\Tenant\Instances\Disk
     */
    protected Disk $disk;

    /**
     * @var string|null
     */
    protected ?string $origin_url;

    /**
     * Config constructor.
     *
     * @param array<string, mixed> $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->origin_url = Arr::get($attributes, 'origin_url', config('app.url'));
        $type = Arr::get($attributes, 'disk.type', Disk::DEFAULT_TYPE);
        $keys = Arr::get($attributes, 'disk.keys', []);
        $this->disk = new Disk($type, $keys);
    }

    /**
     * @return \HibridVod\Database\Models\Tenant\Instances\Disk
     */
    public function getDisk(): Disk
    {
        return $this->disk;
    }

    /**
     * @param \HibridVod\Database\Models\Tenant\Instances\Disk $disk
     */
    public function setDisk(Disk $disk): void
    {
        $this->disk = $disk;
    }

    /**
     * @return string|null
     */
    public function getOriginUrl(): ?string
    {
        return $this->origin_url;
    }

    /**
     * @param string $origin_url
     */
    public function setOriginUrl(string $origin_url): void
    {
        $this->origin_url = $origin_url;
    }
}
