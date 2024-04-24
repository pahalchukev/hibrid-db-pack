<?php

namespace HibridVod\Database\Repository\Contracts;

interface ConnectionInterface
{
    /**
     * @return void
     */
    public function beginTransaction(): void;

    /**
     * @return void
     */
    public function commitTransaction(): void;

    /**
     * @param int|null $toLevel
     */
    public function rollbackTransaction(int $toLevel = null): void;
}
