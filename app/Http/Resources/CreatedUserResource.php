<?php

namespace App\Http\Resources;

use App\Http\Resources\Api\ChildrenResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CreatedUserResource extends JsonResource
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
            'name'     => $this->name,
            'email'    => $this->email,
            'children' => ChildrenResource::collection($this->children),
        ];
    }
}
