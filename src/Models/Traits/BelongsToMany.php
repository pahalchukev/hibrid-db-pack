<?php

namespace HibridVod\Database\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany as BelongsToManyEloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BelongsToMany extends BelongsToManyEloquent
{
    /**
     * @param array<mixed>|Model|\Illuminate\Support\Collection $ids
     * @param bool $detaching
     * @return array<mixed>
     */
    public function sync($ids, $detaching = true): array
    {
        $baseEventData = $this->getBaseEventData();

        $eventData = array_merge($baseEventData, ['related_ids' => $this->processIds($ids)]);
        event('eloquent.syncing: ' . $baseEventData['parent_model'], $eventData);

        $changes = parent::sync($ids, $detaching);

        $eventData = array_merge($baseEventData, ['changes' => $changes]);
        event('eloquent.synced: ' . $baseEventData['parent_model'], $eventData);

        return $changes;
    }

    /**
     * @param mixed $id
     * @param array<mixed> $attributes
     * @param bool $touch
     */
    public function attach($id, array $attributes = [], $touch = true): void
    {
        $baseEventData = $this->getBaseEventData();

        $eventData = array_merge($baseEventData, ['related_ids' => $this->processIds($id)]);

        event('eloquent.attaching: ' . $baseEventData['parent_model'], $eventData);

        parent::attach($id, $attributes, $touch);

        event('eloquent.attached: ' . $baseEventData['parent_model'], $eventData);
    }

    /**
     * @param array<mixed> $ids
     * @param bool $touch
     * @return int
     */
    public function detach($ids = [], $touch = true): int
    {
        $baseEventData = $this->getBaseEventData();

        $eventData = array_merge($baseEventData, ['related_ids' => $this->processIds($ids)]);
        event('eloquent.detaching: ' . $baseEventData['parent_model'], $eventData);

        $results = parent::detach($ids, $touch);

        $eventData = array_merge($baseEventData, ['related_ids' => $this->processIds($ids), 'results' => $results]);
        event('eloquent.detached: ' . $baseEventData['parent_model'], $eventData);

        return $results;
    }

    /**
     * @return array<mixed>
     */
    protected function getBaseEventData(): array
    {
        return array(
            'parent_model' => get_class($this->getParent()),
            'parent_id' => $this->getParent()->getKey(),
            'related_model' => get_class($this->getRelated())
        );
    }

    /**
     * @param mixed $ids
     * @return array<string>
     */
    public function processIds($ids): array
    {
        if ($ids instanceof Collection) {
            $ids = $ids->modelKeys();
        }

        if ($ids instanceof Model) {
            $ids = $ids->getKey();
        }

        return (array)$ids;
    }
}
