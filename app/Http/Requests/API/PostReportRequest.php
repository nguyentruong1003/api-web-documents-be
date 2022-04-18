<?php

namespace App\Http\Requests\API;
class PostReportRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|max:1000',
        ];
    }

    public function attributes()
    {
        return [
            'description' => 'Nội dung',
        ];
    }
}
