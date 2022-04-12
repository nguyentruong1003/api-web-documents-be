<?php

namespace App\Http\Resources;

class PostResource extends APIResource
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
            'post_type_id' => $this->types->name ?? null,
        ];
    }
    
}
