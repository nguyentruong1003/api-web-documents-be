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
        $files = [];
        foreach ($this->files as $file) {
            $files[] = (object) array_merge($file->toArray(), getFileOnGoogleDriveServer($file->id));
        }

        $comments = [];
        foreach ($this->comments as $comment) {
            $comments[] = new CommentResource($comment);
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' =>  $this->description,
            'content' => $this->content,
            'post_type_id' => $this->types->name ?? null,
            'type_slug' => $this->types->slug ?? null,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'comment' => $comments,
            'files' => $files,
            'likes' => $this->likes,
            'reports' => $this->reports,
        ];
    }
}
