<?php

namespace HibridVod\Database\Models\Traits;

/**
 * Trait HasFullTableName
 * @package HibridVod\Database\Traits\Models
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait HasFullTableName
{
    /**
     * @return string
     * @example `connection_name.table_name`
     */
    public static function getFullTableName(): string
    {
        return static::tableName(true);
    }

    /**
     * @return string
     * @example `table_name`
     */
    public static function getShortTableName(): string
    {
        return static::tableName(false);
    }

    /**
     * @param bool $full
     *
     * @return string
     */
    private static function tableName($full = true): string
    {
        // @phpstan-ignore-next-line
        $model = new static();

        if ($full) {
            return sprintf('%s.%s', $model->getConnectionName(), $model->getTable());
        }

        return $model->getTable();
    }
}
