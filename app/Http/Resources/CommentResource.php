<?php

namespace App\Http\Resources;

class CommentResource extends APIResource
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
            'comment' =>  $this->comment,
            'post_id' => $this->post_id,
            'user_id' => $this->user->name ?? $this->user_id,
            'created_at' => $this->created_at,
            'reply' => $this->reply ?? null,
            'likes' => $this->likes ?? null,
        ];
    }
}
