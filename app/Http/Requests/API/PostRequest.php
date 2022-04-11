<?php

namespace App\Http\Requests\API;
class PostRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:1000',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Tiêu đề',
        ];
    }
}
