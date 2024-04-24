<?php

namespace HibridVod\Database\Repository;

use HibridVod\Database\Repository\Contracts\CriteriaInterface;

/**
 * Class CriterionPool
 * @package HibridVod\Database\Repository
 */
final class CriterionPool
{
    /**
     * @var array<string, CriteriaInterface>
     */
    protected array $instances = [];

    /**
     * @param \HibridVod\Database\Repository\Contracts\CriteriaInterface $criteria
     * @param bool                                                       $force
     *
     * @return void
     */
    public function push(CriteriaInterface $criteria, $force = false): void
    {
        $alias = get_class($criteria);
        if ($force || ! $this->has($alias)) {
            $this->instances[$alias] = $criteria;
        }
    }

    /**
     * @param string $alias
     *
     * @return bool
     */
    public function has(string $alias): bool
    {
        return isset($this->instances[$alias]);
    }

    /**
     * @param string $criteria
     */
    public function pop(string $criteria): void
    {
        if ($this->has($criteria)) {
            unset($this->instances[$criteria]);
        }
    }

    /**
     * @return array<string, CriteriaInterface>
     */
    public function all(): array
    {
        return $this->instances;
    }

    /**
     * @return array<string, CriteriaInterface>
     */
    public function reset(): array
    {
        return $this->instances = [];
    }
}
