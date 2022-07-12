<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'make' => $this->make,
            'model' => $this->model,
            'year' => $this->year,
            'trip_count' => $this->when($this->trips_count, fn() => $this->trips_count),
            'trip_miles' => $this->when($this->trips_sum_miles, fn() => $this->trips_sum_miles),
        ];
    }
}
