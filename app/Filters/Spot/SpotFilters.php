<?php

namespace App\Filters\Spot;

use App\Filters\FiltersAbstract;

class SpotFilters extends FiltersAbstract
{
    protected array $filters = [
        'size'           => SizeFilter::class,
        'attributes'     => AttributesFilter::class,
        'datetime_range' => DatetimeFilter::class
    ];
}
