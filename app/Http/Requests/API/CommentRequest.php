<?php

namespace App\Http\Requests\API;

class CommentRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => 'required|max:1000',
        ];
    }

    public function attributes()
    {
        return [
            'comment' => 'Nội dung',
        ];
    }
}
