<?php

namespace HibridVod\Database\Repository\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RepositoryInterface extends ConnectionInterface
{
    /**
     * @param \HibridVod\Database\Repository\Contracts\CriteriaInterface $criteria
     *
     * @return \HibridVod\Database\Repository\Contracts\RepositoryInterface
     */
    public function pushCriteria(CriteriaInterface $criteria): self;

    /**
     * @param string $criteria
     *
     * @return $this
     */
    public function popCriteria(string $criteria): self;

    /**
     * @param string $criteria
     *
     * @return bool
     */
    public function hasCriteria(string $criteria): bool;

    /**
     * @return $this
     */
    public function skipCriteria(): self;

    /**
     * @param array<string, mixed> $attributes
     *
     * @return \HibridVod\Database\Repository\Contracts\EntityInterface
     */
    public function newEntity(array $attributes = []): EntityInterface;

    /**
     * @param \HibridVod\Database\Repository\Contracts\EntityInterface $entity
     *
     * @return \HibridVod\Database\Repository\Contracts\EntityInterface
     */
    public function create(EntityInterface $entity): EntityInterface;

    /**
     * @param \HibridVod\Database\Repository\Contracts\EntityInterface $entity
     *
     * @param array<string, mixed>                                     $attributes
     *
     * @return \HibridVod\Database\Repository\Contracts\EntityInterface
     */
    public function update(EntityInterface $entity, array $attributes = []): EntityInterface;

    /**
     * @param array<string> $relations
     *
     * @return self
     */
    public function with(array $relations = []): RepositoryInterface;

    /**
     * @param mixed $id
     *
     * @return \HibridVod\Database\Repository\Contracts\EntityInterface
     */
    public function find($id): EntityInterface;

    /**
     * @param array<string> $conditions
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findWhere(array $conditions): Collection;

    /**
     * @param \Closure|\Illuminate\Database\Query\Builder|\Illuminate\Database\Query\Expression|string $column
     * @param string                                                                                   $direction
     *
     * @return \HibridVod\Database\Repository\Contracts\RepositoryInterface
     */
    public function orderBy($column, $direction = 'asc'): RepositoryInterface;

    /**
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage): LengthAwarePaginator;

    /**
     * @param \HibridVod\Database\Repository\Contracts\EntityInterface $entity
     *
     * @return mixed
     */
    public function delete(EntityInterface $entity);

    /**
     * Reset repository query state, scopes, criteria, etc...
     */
    public function reset(): void;
}
