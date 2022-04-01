<?php

namespace App\Http\Resources;

class UserResource extends APIResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'permissions' => $this->whenLoaded('permissions', function() {
                return ($this->hasRole('administrator')) ? ['administrator'] : $this->roles()->pluck('name');
            })
        ];

        return $data;
    }
}
