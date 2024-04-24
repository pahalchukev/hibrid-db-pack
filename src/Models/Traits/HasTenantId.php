<?php

namespace HibridVod\Database\Models\Traits;

/**
 * Trait HasTenantId
 * @package HibridVod\Database\Models\Traits
 */
trait HasTenantId
{
    /**
     * @param array<mixed> $data
     * @return array<mixed>
     */
    public function transformAudit(array $data): array
    {
        // @phpstan-ignore-next-line
        $data['tenant_id'] = auth()->user()->tenant_id;
        return $data;
    }
}
