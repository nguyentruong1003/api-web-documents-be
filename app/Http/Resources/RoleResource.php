<?php

namespace App\Http\Resources;

class RoleResource extends APIResource
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
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'users' => UserResource::collection($this->whenLoaded('users')),
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions'))
        ];
    }
}
