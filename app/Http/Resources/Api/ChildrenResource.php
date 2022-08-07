<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin \App\Models\Child */
class ChildrenResource extends JsonResource
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
