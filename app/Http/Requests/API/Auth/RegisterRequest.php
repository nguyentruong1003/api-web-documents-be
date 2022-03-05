<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\API\APIRequest;

class RegisterRequest extends APIRequest
{

    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|max:255|min:6',
            'password_confirmation' => 'required|same:password'
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('models.user.name'),
            'email' => __('models.user.email'),
            'password' => __('models.user.password'),
            'password_confirmation' => __('models.user.password_confirmation')
        ];
    }
}
