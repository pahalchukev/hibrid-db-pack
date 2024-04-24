<?php

namespace HibridVod\Database\Contracts;

interface HasUuid
{
    /**
     * @return string|null
     */
    public function getUuid(): ?string;
}
