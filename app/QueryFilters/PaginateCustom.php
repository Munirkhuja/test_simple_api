<?php

namespace App\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class PaginateCustom
{
    public function handle(Builder $query, $next)
    {
        if (request()->has('limit') && request('limit') < config('simple.max_limit')) {
            $limit = request('limit');
        } else {
            $limit = config('simple.limit');
        }

        return $next($query->paginate($limit));
    }
}
