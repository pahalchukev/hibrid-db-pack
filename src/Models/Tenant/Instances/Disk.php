<?php

namespace HibridVod\Database\Models\Tenant\Instances;

final class Disk
{
    public const DEFAULT_TYPE = 'local';

    /**
     * @var string
     */
    protected string $type;

    /**
     * @var array<string>
     */
    protected array $keys;

    /**
     * Disk constructor.
     *
     * @param string $type
     * @param array<string>  $keys
     */
    public function __construct(string $type, array $keys = [])
    {
        $this->type = $type;
        $this->keys = $keys;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return array<string>
     */
    public function getKeys(): array
    {
        return $this->keys;
    }

    /**
     * @param array<string> $keys
     */
    public function setKeys(array $keys): void
    {
        $this->keys = $keys;
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function is(string $type): bool
    {
        return $this->type === $type;
    }
}
