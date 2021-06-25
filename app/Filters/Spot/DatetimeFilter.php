<?php

namespace App\Filters\Spot;

use App\Filters\FilterInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class DatetimeFilter implements FilterInterface
{
    /**
     * @param Builder $builder
     * @param mixed $values
     *  //                      |---------|
     * case1      |---|                                     // happy
     * case2                                |---|           // happy
     * case3       |------------|                           // unhappy
     * case4                   |--|                         // unhappy
     * case5                      |--------|                // unhappy
     * case6     |-----------------------------|            // unhappy
     * @return Builder
     */
    public function filter(Builder $builder, mixed $values): Builder
    {
        return $builder->whereDoesntHave('reservations', function (Builder $query) use ($values) {
            $query->where([
                ['start', '<=', Carbon::parse(Arr::get($values, 'end'))],
                ['end', '>=', Carbon::parse(Arr::get($values, 'start'))],
            ]);
        });
    }
}
