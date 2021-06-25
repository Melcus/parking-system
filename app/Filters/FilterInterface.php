<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function filter(Builder $builder, mixed $values);
}
