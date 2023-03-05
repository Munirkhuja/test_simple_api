<?php

namespace App\QueryFilters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

trait FilterDateAt
{
    public function filterDate_at(Builder $query, $key)
    {
        $equalHas = request()->has("{$key}");
        $fromHas = request()->has("{$key}_from");
        $toHas = request()->has("{$key}_to");
        try {
            if ($equalHas) {
                $date = Carbon::parse(request("{$key}"))->toDateString();

                return $query->whereDate("{$key}", $date);
            }
            if ($fromHas && $toHas) {
                $dateFrom = Carbon::parse(request("{$key}_from"));
                $dateTo = Carbon::parse(request("{$key}_to"))->addDay()->addSeconds(-1);

                return $query->whereBetween("{$key}", [$dateFrom, $dateTo]);
            }
            if ($fromHas && !$toHas) {
                $dateFrom = Carbon::parse(request("{$key}_from"));

                return $query->where("{$key}", '>=', $dateFrom);
            }
            if (!$fromHas && $toHas) {
                $dateTo = Carbon::parse(request("{$key}_to"))->addDay()->addSeconds(-1);

                return $query->where("{$key}", '<=', $dateTo);
            }
        } catch (\Exception $exception) {
            Log::build(
                [
                    'driver' => 'single',
                    'path' => storage_path('logs/filter_error.log'),
                ]
            )->error($exception->getMessage());
        }

        return $query;
    }
}
