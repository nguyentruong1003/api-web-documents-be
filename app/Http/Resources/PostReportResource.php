<?php

namespace App\Http\Resources;

class PostReportResource extends APIResource
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
            'id' => $this->id,
            'post' => $this->post,
            'user' => $this->user,
            'description' => $this->description,
            'resolve' => $this->resolve,
        ];
    }
}
