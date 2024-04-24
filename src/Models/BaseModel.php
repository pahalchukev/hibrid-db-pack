<?php

namespace HibridVod\Database\Models;

use Illuminate\Database\Eloquent\Model;
use HibridVod\Database\Models\Traits\HasFullTableName;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

/**
 * Class BaseModel
 * @package HibridVod\Database\Models
 */
abstract class BaseModel extends Model
{
    use UsesSystemConnection;
    use HasFullTableName;

    /**
     * @var array<string, array<string>>
     */
    protected static array $hiddenAttributes = [];

    /**
     * @var array<string, array<string>>
     */
    protected static array $includedAttributes = [];

    /**
     * @var array<string, array<string>>
     */
    protected static array $includedRelations = [];

    /**
     * @param array<string> $attributes
     *
     * @return void
     */
    public static function hideAttributes(array $attributes): void
    {
        static::$hiddenAttributes[static::class] = $attributes;
    }

    /**
     * Get list of hidden attributes specified for current model
     *
     * @return array<string>
     */
    public static function getHiddenAttributes(): array
    {
        return static::$hiddenAttributes[static::class] ?? [];
    }

    /**
     * @param array<string> $attributes
     *
     * @return void
     */
    public static function includeAttributes(array $attributes): void
    {
        static::$includedAttributes[static::class] = $attributes;
    }

    /**
     * Get list of included attributes specified for current model
     *
     * @return array<string>
     */
    public static function getIncludedAttributes(): array
    {
        return static::$includedAttributes[static::class] ?? [];
    }

    /**
     * @param array<string> $attributes
     *
     * @return void
     */
    public static function includeRelations(array $attributes): void
    {
        static::$includedRelations[static::class] = $attributes;
    }

    /**
     * @return array<string>
     */
    public static function getIncludedRelations(): array
    {
        return static::$includedRelations[static::class] ?? [];
    }

    /**
     * BaseModel constructor.
     *
     * @param array<string, mixed> $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->with = array_merge($this->with, static::getIncludedRelations());
    }

    /**
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();
        static::retrieved(static function (BaseModel $model) {
            $model->setHidden(
                array_merge($model->getHidden(), static::getHiddenAttributes())
            );

            $model->setAppends(
                array_merge($model->getAppends(), static::getIncludedAttributes())
            );
        });
    }

    /**
     * @return array<string>
     */
    public function getAppends(): array
    {
        return $this->appends;
    }
}
