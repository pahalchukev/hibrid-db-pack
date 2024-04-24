<?php

namespace HibridVod\Database;

use Illuminate\Support\Facades\Schema;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

/**
 * Class Migration
 * @package PropertySpace\Database
 * @method \Illuminate\Database\Schema\Builder create(string $table, \Closure $callback)
 * @method \Illuminate\Database\Schema\Builder drop(string $table)
 * @method \Illuminate\Database\Schema\Builder dropIfExists(string $table)
 * @method \Illuminate\Database\Schema\Builder table(string $table, \Closure $callback)
 * @method \Illuminate\Database\Schema\Builder rename(string $from, string $to)
 * @method bool hasTable(string $table)
 * @method bool hasColumn(string $table, string $column)
 * @method bool hasColumns(string $table, array $columns)
 */
class Migration extends \Illuminate\Database\Migrations\Migration
{
    use UsesSystemConnection;

    /**
     * @param string $name
     * @param mixed  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $connection = Schema::connection($this->getConnectionName());

        return $connection->$name(...$arguments);
    }
}
