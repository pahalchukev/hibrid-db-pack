<?php

namespace HibridVod\Database\Models\Traits;

use Ramsey\Uuid\Uuid;
use HibridVod\Database\Contracts\HasUuid;

/**
 * Trait Uuidable
 * @package HibridVod\Database\Models\Traits
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait Uuidable
{
    /**
     * Boot model trait
     */
    public static function bootUuidable(): void
    {
        static::saving(static function (self $model) {
            if (
                $model instanceof HasUuid &&
                ! $model->exists &&
                ! $model->getKey()
            ) {
                $model->setAttribute(
                    $model->getKeyName(),
                    Uuid::uuid4()->toString()
                );
            }
        });
    }

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->getKey();
    }
}
