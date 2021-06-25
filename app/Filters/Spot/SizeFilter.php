<?php

namespace App\Filters\Spot;

use App\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class SizeFilter implements FilterInterface
{
    public function filter(Builder $builder, mixed $values): Builder
    {
        return $builder->whereHas('size', function (Builder $builder) use ($values) {
            $builder->where('name', $values);
        });
    }
}
