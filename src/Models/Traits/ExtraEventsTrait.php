<?php

namespace HibridVod\Database\Models\Traits;

trait ExtraEventsTrait
{
    /**
     * @param mixed $related
     * @param null|string $table
     * @param null|string $foreignPivotKey
     * @param null|string $relatedPivotKey
     * @param mixed $parentKey
     * @param mixed $relatedKey
     * @param mixed $relation
     * @return BelongsToMany
     */
    public function belongsToMany(
        $related,
        $table = null,
        $foreignPivotKey = null,
        $relatedPivotKey = null,
        $parentKey = null,
        $relatedKey = null,
        $relation = null
    ): BelongsToMany {
        /** @noinspection PhpMultipleClassDeclarationsInspection */
        $belongsToMany = parent::belongsToMany(
            $related,
            $table,
            $foreignPivotKey,
            $relatedPivotKey,
            $parentKey,
            $relatedKey,
            $relation
        );

        $query = $belongsToMany->getQuery()->getModel()->newQuery();
        $parent = $belongsToMany->getParent();
        $table = $belongsToMany->getTable();
        $instance = $this->newRelatedInstance($related);

        $foreignPivotKey = explode('.', $belongsToMany->getQualifiedForeignPivotKeyName())[1];
        $relatedPivotKey = explode('.', $belongsToMany->getQualifiedRelatedPivotKeyName())[1];
        $relation = $belongsToMany->getRelationName();

        return new BelongsToMany(
            $query,
            $parent,
            $table,
            $foreignPivotKey,
            $relatedPivotKey,
            $parentKey ?: $this->getKeyName(),
            $relatedKey ?: $instance->getKeyName(),
            $relation
        );
    }
}
