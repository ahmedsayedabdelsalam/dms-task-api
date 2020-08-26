<?php

namespace App\Contracts\Scopes;

use Spatie\QueryBuilder\QueryBuilder;

interface WithRequestQueryBuilder
{
    public function scopeUsingRequestQueryBuilder(): QueryBuilder;
}
