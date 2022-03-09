<?php

namespace App\Editors;

class MasterDataEditor extends Editor
{

    public function handleSave()
    {
        $this->model->fill([
            'v_key' => $this->data['v_key'],
            'v_value' =>  $this->data['v_value'],
            'order_number' => $this->data['order_number'] ?? null,
            'type' => $this->data['type'],
            'parent_id' => $this->data['parent_id'] ?? null,
            'v_content' => $this->data['v_content'],
            'note' => $this->data['note'],
        ]);
        $this->model->save();
    }
}
