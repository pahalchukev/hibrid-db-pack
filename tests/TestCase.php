<?php

namespace HibridVod\Database\Tests;

use Mockery as m;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\DatabaseServiceProvider;
use Spatie\Permission\PermissionServiceProvider;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class TestCase
 * @package HibridVod\Database\Tests
 */
abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        m::globalHelpers();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    /**
     * Load package service provider
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            DatabaseServiceProvider::class,
            PermissionServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'system');
        $app['config']->set('database.connections.system', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    protected static function assertHasSystemConnection(Model $model): void
    {
        self::assertEquals('system', $model->getConnectionName());
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array                               $columns
     */
    protected static function assertModelTableHasColumns(Model $model, array $columns): void
    {
        self::assertTrue(Schema::hasColumns($model->getTable(), $columns));
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array                               $fillable
     */
    protected static function assertModelHasFillableColumns(Model $model, array $fillable): void
    {
        self::assertEquals($fillable, $model->getFillable());
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array                               $attributes
     */
    protected static function assertModelHasAppendedAttributes(Model $model, array $attributes): void
    {
        self::assertEquals($attributes, $model->getAppends());
    }

    /**
     * @param Model $model
     * @param array $attributes
     */
    protected static function assertModelHasHiddenAttributes(Model $model, array $attributes): void
    {
        self::assertEquals($attributes, $model->getHidden());
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model|HasUuid $model
     */
    protected static function assertModelHasStringIdentifier(Model $model): void
    {
        self::assertInstanceOf(HasUuid::class, $model);
        self::assertFalse($model->getIncrementing());
        self::assertEquals('string', $model->getKeyType());
        self::assertIsString($model->getUuid());
    }

    /**
     * @param \Illuminate\Database\Eloquent\Relations\Relation $relation
     * @param string                                           $foreign_key
     * @param string                                           $primary_key
     * @param array|null                                       $keys
     */
    protected static function assertModelRelationKeys(Relation $relation, string $foreign_key, string $primary_key = 'id', array $keys = null): void
    {
        if ($relation instanceof HasMany || $relation instanceof HasOne) {
            self::assertEquals($primary_key, $relation->getLocalKeyName());
        } else if ($relation instanceof HasManyThrough) {
            self::assertEquals($keys['firstKey'], $relation->getFirstKeyName());
            self::assertEquals($foreign_key, $relation->getForeignKeyName());
            self::assertEquals($primary_key, $relation->getLocalKeyName());
            self::assertEquals($keys['secondaryLocalKey'], $relation->getSecondLocalKeyName());
        } else if ($relation instanceof BelongsToMany) {
            self::assertEquals($foreign_key, $relation->getForeignPivotKeyName());
            self::assertEquals($primary_key, $relation->getRelatedPivotKeyName());

            return;
        } else {
            self::assertEquals($primary_key, $relation->getOwnerKeyName());
        }

        self::assertEquals($foreign_key, $relation->getForeignKeyName());
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string[]                            $traits
     */
    protected static function assertModelHasTraits(Model $model, array $traits): void
    {
        try {
            $modelTraits = (new \ReflectionClass($model))->getTraits();
            $modelTraits = array_map(static fn(\ReflectionClass $trait) => $trait->getName(), $modelTraits);
            $modelTraits = array_values($modelTraits);

            self::assertEquals($traits, $modelTraits);

        } catch (\ReflectionException $e) {
            self::fail($e->getMessage());
        }
    }
}
