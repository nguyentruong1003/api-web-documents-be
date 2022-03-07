<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\API\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends APIRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required|min:6|max:255',
            'new_password' => 'required|min:6|max:255',
            'new_password_confirmation' => 'required|same:new_password'
        ];
    }

    public function attributes()
    {
        return [
            'old_password' => __('models.user.old_password'),
            'new_password' => __('models.user.new_password'),
            'new_password_confirmation' => __('models.user.new_password_confirmation')
        ];
    }
}
