<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\API\APIRequest;

class LoginRequest extends APIRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'email' => __('models.user.email'),
            'name' => __('models.user.name'),
        ];
    }
}
