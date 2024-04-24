<?php

namespace HibridVod\Database\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use HibridVod\Database\Models\Traits\HasFullTableName;
use HibridVod\Database\Models\Traits\UsesSystemConnection;

/**
 * Class BasePivotModel
 * @package HibridVod\Database\Models
 */
abstract class BasePivotModel extends Pivot
{
    use UsesSystemConnection;
    use HasFullTableName;
}
