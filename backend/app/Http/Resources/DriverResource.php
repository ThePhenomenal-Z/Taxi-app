<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user=$this->user()->get();
       // dd($user);
        $phoneNumber=$user[0]["phoneNumber"];
        $name=$user[0]["name"];
        return [
            "id"=>$this->id,
            "year"=>$this->year,
            "type"=>$this->type,
            "model"=>$this->model,
            "color"=>$this->color,
            "license_plate"=>$this->license_plate,
            "phoneNumber"=>$phoneNumber,
            "name"=>$name
        ];
    }
}
