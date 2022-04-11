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
            'id' => $this->id,
            'title' => $this->title,
            'description' =>  $this->v_value,
            'content' => $this->content,
            'post_type_id' => $this->types->name,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'comment' => $this->comments,
        ];
    }
}
