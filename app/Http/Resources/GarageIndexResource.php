<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GarageIndexResource extends JsonResource
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
            'id'          => $this->id,
            'name'        => $this->name,
            'zipcode'     => $this->zipcode,
            'coordinates' => [
                'lng' => $this->lng,
                'lat' => $this->lat
            ],
            'total_spots' => $this->total_spots,
            'free_spots'  => $this->free_spots,
        ];
    }
}
