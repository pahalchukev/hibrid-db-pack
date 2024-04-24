<?php

namespace HibridVod\Database\Repository\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface CriteriaInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder                        $builder
     * @param \HibridVod\Database\Repository\Contracts\RepositoryInterface $repository
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder, RepositoryInterface $repository): Builder;
}
