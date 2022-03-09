<?php

namespace App\Http\Resources;

class MasterDataResource extends APIResource
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
            'v_key' => $this->v_key,
            'v_value' =>  $this->v_value,
            'order_number' => $this->order_number,
            'type' => $this->type,
            'parent_id' => $this->parent_id,
            'v_content' => $this->v_content,
            'note' => $this->note
        ];
    }
}
