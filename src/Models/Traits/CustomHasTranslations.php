<?php

namespace HibridVod\Database\Models\Traits;

use Spatie\Translatable\HasTranslations;

trait CustomHasTranslations
{
    use HasTranslations;

    /**
     * @return false|string
     */
    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
