<?php

namespace App\Http\Requests\API;

use Illuminate\Validation\Rule;

class PermissionRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $permission = $this->route('permission');
        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('permissions', 'name')->where('guard_name', 'api')->ignore($permission->id ?? null)
            ]
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('models.permission.name')
        ];
    }
}
