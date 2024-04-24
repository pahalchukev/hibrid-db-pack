<?php

namespace HibridVod\Database\Tests\Repository;

use Exception;
use Illuminate\Database\Connection;
use HibridVod\Database\Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use HibridVod\Database\Repository\AbstractRepository;
use HibridVod\Database\Repository\Contracts\EntityInterface;
use HibridVod\Database\Repository\Contracts\CriteriaInterface;
use HibridVod\Database\Repository\Contracts\RepositoryInterface;

class RepositoryTest extends TestCase
{
    /**
     * @var \HibridVod\Database\Tests\Repository\FakeModel|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $model;

    /**
     * @var \HibridVod\Database\Tests\Repository\FakeRepository
     */
    private FakeRepository $repository;

    /**
     * @var \Illuminate\Database\Connection|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $modelConnection;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpModel();
        $this->repository = new FakeRepository($this->model);
    }

    /** @test */
    public function it_should_have_bootable_criteria(): void
    {
        self::assertTrue(
            $this->repository->hasCriteria(FakeBootableCriteria::class)
        );
    }

    /**
     * @test
     * @depends it_should_have_bootable_criteria
     */
    public function it_cat_pop_criteria(): void
    {
        $this->repository->popCriteria(FakeBootableCriteria::class);

        self::assertFalse(
            $this->repository->hasCriteria(FakeBootableCriteria::class)
        );
    }

    /** @test */
    public function it_cat_push_criteria(): void
    {
        $this->repository->pushCriteria(new FakePushableCriteria());

        self::assertTrue(
            $this->repository->hasCriteria(FakePushableCriteria::class)
        );
    }

    /** @test */
    public function it_can_make_new_entity(): void
    {
        $this->model->shouldReceive('newInstance')
            ->once()
            ->with($attributes = ['key' => 'value'])
            ->andReturnSelf();

        $this->repository->newEntity($attributes);
    }

    /** @test */
    public function it_can_create_new_entity(): void
    {
        $this->mockTransaction();

        $this->model
            ->shouldReceive('newInstance')
            ->once()
            ->with($attributes = ['foo' => 'bar'])
            ->andReturnSelf()
            ->getMock()
            ->shouldReceive('save')
            ->andReturnTrue();

        $entity = $this->repository->newEntity($attributes);

        self::assertEquals($this->model, $this->repository->create($entity));
    }

    /** @test */
    public function it_will_rollback_transaction_if_save_failed(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('some exception message');
        $this->mockTransaction(true);

        $this->model
            ->shouldReceive('save')
            ->andThrows(Exception::class, 'some exception message');

        $this->repository->create($this->model);
    }

    /** @test */
    public function it_can_update_entity(): void
    {
        $this->mockTransaction();

        $this->model
            ->shouldReceive('fill')
            ->once()
            ->with($attributes = ['key' => 'value'])
            ->andReturnSelf()
            ->getMock()
            ->shouldReceive('save')
            ->andReturnTrue();

        $this->repository->update($this->model, $attributes);
    }

    /** @test */
    public function it_can_find_entity_by_primary_key(): void
    {
        $this->mockBuilder()
            ->shouldReceive('firstOrFail')
            ->andReturn($this->model);

        $this->repository->find(2);
    }

    /** @test */
    public function it_can_apply_order_before_executing_query(): void
    {
        $this->mockBuilder()
            ->shouldReceive('orderBy')
            ->times(3)
            ->withAnyArgs()
            ->andReturn($this->repository);

        $this->repository->orderBy('column1')
            ->orderBy('column2')
            ->orderBy('column3', 'desc');
    }

    /** @test */
    public function it_can_find_first_entity(): void
    {
        $this->mockBuilder()
            ->shouldReceive('first')
            ->with(['*'])
            ->andReturn($this->model);

        $this->repository->first();
    }

    /** @test */
    public function it_can_find_entities_by_array_of_conditions_and_return_collection(): void
    {
        $this->mockBuilder()
            ->shouldReceive('where')
            ->with($attributes = [
                'field' => 'value',
            ])
            ->andReturnSelf()
            ->getMock()
            ->shouldReceive('get')
            ->withNoArgs()
            ->once()
            ->andReturn(Collection::make([$this->model]));

        $this->repository->findWhere($attributes);
    }

    /** @test */
    public function it_can_return_paginated_collection(): void
    {
        $this->mockBuilder()
            ->shouldReceive('paginate')
            ->with(2, ['*'])
            ->andReturn(new LengthAwarePaginator([$this->model], 1, 2));

        $result = $this->repository->paginate(2);

        self::assertCount(1, $result->items());
        self::assertEquals(2, $result->perPage());
    }

    /** @test */
    public function it_can_attach_relations_to_include(): void
    {
        $this->mockBuilder()
            ->shouldReceive('firstOrFail')
            ->andReturn($this->model)
            ->getMock()
            ->shouldReceive('with')
            ->once()
            ->with(['foo'])
            ->andReturnSelf();

        $this->repository->with(['foo']);
    }

    /** @test */
    public function it_can_delete_entity(): void
    {
        $this->model
            ->shouldReceive('delete')
            ->once()
            ->withNoArgs()
            ->andReturnNull();

        $this->repository->delete($this->model);
    }

    /** @test */
    public function it_can_reset_repository(): void
    {
       $this->repository->pushCriteria(new FakePushableCriteria());
       $hadCriteria = $this->repository->hasCriteria(FakePushableCriteria::class);
       $this->repository->reset();

       self::assertTrue($hadCriteria);
       self::assertFalse($this->repository->hasCriteria(FakePushableCriteria::class));
    }

    protected function setUpModel(): void
    {
        $this->model = mock(FakeModel::class);
        $this->modelConnection = mock(Connection::class);

        $this->model->shouldReceive('getConnection')
            ->once()
            ->withNoArgs()
            ->andReturn($this->modelConnection);
    }

    protected function mockTransaction(bool $willThrowException = false): void
    {
        $this->modelConnection->shouldReceive('beginTransaction')
            ->once()
            ->withNoArgs()
            ->andReturnNull();

        $this->modelConnection->shouldReceive($willThrowException ? 'rollback' : 'commit')
            ->once()
            ->andReturnNull();
    }

    protected function mockBuilder()
    {
        $builder = mock(Builder::class);
        $this->model->shouldReceive('newQuery')
            ->once()
            ->withNoArgs()
            ->andReturn($builder);

        return $builder;
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model, $this->repository);
    }
}

final class FakeRepository extends AbstractRepository
{
    protected function boot(): void
    {
        $this->pushCriteria(new FakeBootableCriteria());
    }
}

class FakeModel extends Model implements EntityInterface
{
}

final class FakeBootableCriteria implements CriteriaInterface
{
    public function apply(Builder $builder, RepositoryInterface $repository): Builder
    {
        return $builder;
    }
}

final class FakePushableCriteria implements CriteriaInterface
{
    public function apply(Builder $builder, RepositoryInterface $repository): Builder
    {
        return $builder;
    }
}
