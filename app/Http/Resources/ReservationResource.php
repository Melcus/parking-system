<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'id'           => $this->id,
            'spot_id'      => (string)$this->spot_id,
            'start'        => $this->start->toDateTimeString(),
            'end'          => $this->end->toDateTimeString(),
            'paid_at'      => optional($this->paid_at)->toDateTimeString(),
            'paid_amount'  => $this->paid_amount,
            'created_at'   => $this->created_at->toDateTimeString()
        ];
    }
}
