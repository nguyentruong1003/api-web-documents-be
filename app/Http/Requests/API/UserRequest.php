<?php

namespace App\Http\Requests\API;

class UserRequest extends APIRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route('user');
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email' . (empty($user) ? '' : ',' . $user->id),
            'password' => 'required|min:6',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('models.user.name'),
            'email' => __('models.user.email'),
            'password' => __('models.user.password'),
            'roles.*' => __('models.user.role_id')
        ];
    }
}
