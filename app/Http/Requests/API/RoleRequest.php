<?php

namespace App\Http\Requests\API;

class RoleRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id'
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('models.role.name'),
            'users.*' => __('models.role.user_id'),
            'permissions.*' => __('models.role.permission_id'),
        ];
    }
}
