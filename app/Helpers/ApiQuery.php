<?php

namespace App\Helpers;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ApiQuery
{
    public static function buildPostQuery($query): QueryBuilder
    {
        return QueryBuilder::for($query)
            ->allowedIncludes('user')
            ->allowedFilters(
                AllowedFilter::exact('status'),
                AllowedFilter::partial('title'),
                AllowedFilter::exact('user_id')
            )
            ->allowedSorts('id', 'title', 'status', 'created_at')
            ->defaultSort('-created_at');
    }
}
