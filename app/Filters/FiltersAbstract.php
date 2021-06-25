<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class FiltersAbstract
{
    private array $parameters;

    protected array $filters = [];

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function filter(Builder $builder): Builder
    {
        foreach ($this->parameters as $filter => $values) {
            $this->resolveFilter($filter)->filter($builder, $values);
        }

        return $builder;
    }

    private function resolveFilter(string $filter)
    {
        return new $this->filters[$filter];
    }
}
