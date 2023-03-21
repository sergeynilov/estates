<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EstateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'bedrooms'  => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'storeys'   => $this->storeys,
            'garages'   => $this->garages,
            'price'     => $this->price,
        ];
    }

    public function with($request)
    {
        return [
            'meta' => [
                'version' => 0.1
            ]
        ];
    }

}


