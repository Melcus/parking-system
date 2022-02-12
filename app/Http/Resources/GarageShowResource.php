<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GarageShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'zipcode'    => $this->zipcode,
            'sizes'      => $this->prices->transform(function ($entry) {
                return
                    [
                        'name'  => $entry->size->name,
                        'price' => $entry->base,
                        'rates' => $entry->rates
                    ];
            }),
            'attributes' => $this->spotAttributes->pluck('pivot.price_per_hour', 'name')
        ];
    }
}
