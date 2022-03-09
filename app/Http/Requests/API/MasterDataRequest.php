<?php

namespace App\Http\Requests\API;
class MasterDataRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'v_key' => 'required|max:255',
            'v_value' =>  'required|max:255',
            'order_number' => 'required|numeric|min:0',
            'type' => 'required|max:10',
            'parent_id' => 'nullable|numeric',
            'v_content' => 'nullable|max:1000',
            'note' => 'nullable|max:1000',
        ];
    }

    public function attributes()
    {
        return [
            'v_key' => __('models.master_data.v_key'),
            'v_value' =>  __('models.master_data.v_value'),
            'order_number' => __('models.master_data.order_number'),
            'type' => __('models.master_data.type'),
            'parent_id' => __('models.master_data.parent_id'),
            'v_content' =>  __('models.master_data.v_content'),
            'note' => __('models.master_data.note'),
        ];
    }
}
