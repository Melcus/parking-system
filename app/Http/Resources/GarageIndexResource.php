<?php

declare(strict_types=1);

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
                'lng' => round($this->lng, 4),
                'lat' => round($this->lat, 4)
            ],
            'total_spots' => (int)$this->total_spots,
            'free_spots'  => (int)$this->free_spots,
        ];
    }
}
