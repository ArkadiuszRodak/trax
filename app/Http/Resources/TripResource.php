<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'miles' => $this->miles,
            'total' => $this->total,
            'car' => new CarResource($this->car),
        ];
    }
}
