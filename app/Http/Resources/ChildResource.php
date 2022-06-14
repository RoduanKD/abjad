<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChildResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name'      => $this->name,
            'is_male'   => $this->is_male,
            'birthdate' => $this->birthdate,
            'image'     => $this->getFirstMediaUrl('profile'),
        ];
    }
}
