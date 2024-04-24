<?php

namespace HibridVod\Database\Repository;

use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use HibridVod\Database\Repository\Contracts\EntityInterface;
use HibridVod\Database\Repository\Contracts\CriteriaInterface;
use HibridVod\Database\Repository\Contracts\RepositoryInterface;

/**
 * Class BaseRepository
 * @package HibridVod\Database\Repository
 */
abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @var \HibridVod\Database\Repository\Contracts\EntityInterface
     */
    protected EntityInterface $entityModel;

    /**
     * @var \Illuminate\Database\Connection
     */
    protected Connection $connection;

    /**
     * @var \HibridVod\Database\Repository\CriterionPool
     */
    private CriterionPool $criterionPool;

    /**
     * @var \Illuminate\Database\Eloquent\Builder|null
     */
    private ?Builder $query = null;

    /**
     * BaseRepository constructor.
     *
     * @param \HibridVod\Database\Repository\Contracts\EntityInterface $entityModel
     */
    public function __construct(EntityInterface $entityModel)
    {
        $this->entityModel = $entityModel;
        $this->connection = $this->entityModel->getConnection();
        $this->criterionPool = new CriterionPool();
        $this->boot();
    }

    /**
     * @param \HibridVod\Database\Repository\Contracts\CriteriaInterface $criteria
     *
     * @return \HibridVod\Database\Repository\Contracts\RepositoryInterface
     */
    public function pushCriteria(CriteriaInterface $criteria): RepositoryInterface
    {
        $this->criterionPool->push($criteria);

        return $this;
    }

    /**
     * @param string $criteria
     *
     * @return \HibridVod\Database\Repository\Contracts\RepositoryInterface
     */
    public function popCriteria(string $criteria): RepositoryInterface
    {
        $this->criterionPool->pop($criteria);

        return $this;
    }

    /**
     * @param string $criteria
     *
     * @return bool
     */
    public function hasCriteria(string $criteria): bool
    {
        return $this->criterionPool->has($criteria);
    }

    /**
     * @return \HibridVod\Database\Repository\Contracts\RepositoryInterface
     */
    public function skipCriteria(): RepositoryInterface
    {
        $this->criterionPool->reset();

        return $this;
    }

    /**
     * @throws \Throwable
     */
    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    /**
     * @throws \Throwable
     */
    public function commitTransaction(): void
    {
        $this->connection->commit();
    }

    /**
     * @param int|null $toLevel
     *
     * @throws \Throwable
     */
    public function rollbackTransaction(int $toLevel = null): void
    {
        $this->connection->rollBack($toLevel);
    }

    /**
     * @param array<string, mixed> $attributes
     *
     * @return \HibridVod\Database\Repository\Contracts\EntityInterface
     */
    public function newEntity(array $attributes = []): EntityInterface
    {
        /** @phpstan-ignore-next-line */
        return $this->entityModel->newInstance($attributes);
    }

    /**
     * @param \HibridVod\Database\Repository\Contracts\EntityInterface $entity
     *
     * @return \HibridVod\Database\Repository\Contracts\EntityInterface
     * @throws \Throwable
     */
    public function create(EntityInterface $entity): EntityInterface
    {
        return $this->saveEntity($entity);
    }

    /**
     * @param \HibridVod\Database\Repository\Contracts\EntityInterface $entity
     *
     * @param array<string, mixed>                                     $attributes
     *
     * @return \HibridVod\Database\Repository\Contracts\EntityInterface
     * @throws \Throwable
     */
    public function update(EntityInterface $entity, array $attributes = []): EntityInterface
    {
        $entity->fill($attributes);

        return $this->saveEntity($entity);
    }

    /**
     * @param array<string> $relations
     *
     * @return \HibridVod\Database\Repository\Contracts\RepositoryInterface
     */
    public function with(array $relations = []): RepositoryInterface
    {
        $this->makeQuery()->with($relations);

        return $this;
    }

    /**
     * @param mixed $id
     *
     * @return \HibridVod\Database\Repository\Contracts\EntityInterface
     */
    public function find($id): EntityInterface
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        /** @phpstan-ignore-next-line */
        return $this->makeQuery()->firstOrFail($id);
    }

    /**
     * @param array<mixed> $conditions
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findWhere(array $conditions): Collection
    {
        return $this->makeQuery()->where($conditions)->get();
    }

    /**
     * @param array<string> $columns
     *
     * @return \HibridVod\Database\Repository\Contracts\EntityInterface|null
     */
    public function first(array $columns = ['*']): ?EntityInterface
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        // @phpstan-ignore-next-line
        return $this->makeQuery()->first($columns);
    }

    /**
     * @param \Closure|\Illuminate\Database\Query\Builder|\Illuminate\Database\Query\Expression|string $column
     * @param string                                                                                   $direction
     *
     * @return \HibridVod\Database\Repository\Contracts\RepositoryInterface
     */
    public function orderBy($column, $direction = 'asc'): RepositoryInterface
    {
        $this->makeQuery()->orderBy($column, $direction);

        return $this;
    }

    /**
     * @param int           $perPage
     *
     * @param array<string> $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->makeQuery()->paginate($perPage, $columns);
    }

    /**
     * @param \HibridVod\Database\Repository\Contracts\EntityInterface $entity
     *
     * @return mixed|void
     * @throws \Exception
     */
    public function delete(EntityInterface $entity)
    {
        $entity->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function reset(): void
    {
        $this->query = null;
        $this->criterionPool->reset();
    }

    /**
     * @return void
     */
    protected function boot(): void
    {
        //
    }

    /**
     * @param \HibridVod\Database\Repository\Contracts\EntityInterface $entity
     *
     * @return \HibridVod\Database\Repository\Contracts\EntityInterface
     * @throws \Throwable
     */
    protected function saveEntity(EntityInterface $entity): EntityInterface
    {
        $this->beginTransaction();

        try {
            $entity->save();
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }

        $this->commitTransaction();

        return $entity;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function makeQuery(): Builder
    {
        if ($this->query !== null) {
            return $this->query;
        }
        $this->query = $this->entityModel->newQuery();

        foreach ($this->criterionPool->all() as $criteria) {
            $this->query = $criteria->apply($this->query, $this);
        }

        return $this->query;
    }
}
