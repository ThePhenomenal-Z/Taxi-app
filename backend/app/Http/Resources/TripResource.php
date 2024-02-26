<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "user_id"=>$this->user_id,
            "driver_id"=>$this->driver_id,
            "status"=>$this->status,
            "origin"=>$this->origin,
            "destination"=>$this->destination,
            "destination_name"=>$this->destination_name,
            "driver_location"=>$this->driver_location,
        ];
    }
}
