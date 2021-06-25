<?php

namespace App\Filters\Spot;

use App\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class AttributesFilter implements FilterInterface
{
    public function filter(Builder $builder, mixed $values): Builder
    {
        foreach ($values as $attribute) {
            $builder->whereHas('spotAttributes', function (Builder $builder) use ($attribute) {
                $builder->where('name', $attribute);
            });
        }

        return $builder;
    }
}
