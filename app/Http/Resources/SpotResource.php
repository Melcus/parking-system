<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpotResource extends JsonResource
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
            'size'       => $this->size->name,
            'floor'      => $this->floor,
            'number'     => $this->number,
            'attributes' => $this->spotAttributes->pluck('name')
        ];
    }
}
