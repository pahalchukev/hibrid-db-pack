<?php

namespace HibridVod\Database\Models\Traits;

use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\Tenant\Tenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Trait HasDefaultRelations
 * @package HibridVod\Database\Traits\Models
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait HasDefaultRelations
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
