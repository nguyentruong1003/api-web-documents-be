<?php

namespace App\Http\Controllers\API;

use App\Editors\RoleEditor;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\RoleRequest;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Get roles
     *
     * @group Role management
     * @authenticated
     */
    public function index(Request $request)
    {
        return RoleResource::collection(Role::query()->paginate(15));
    }

    /**
     * Create role
     *
     * @group Role management
     * @authenticated
     */
    public function create(RoleRequest $request)
    {
        $role = RoleEditor::open(new Role())->withDataFromRequest($request)->save();
        return (new RoleResource($role))->withMessage(__('view.notification.success.create'));
    }

    /**
     * Edit role
     *
     * @group Role management
     * @authenticated
     */
    public function edit(RoleRequest $request, Role $role)
    {
        $role = RoleEditor::open($role)->withDataFromRequest($request)->save();
        return (new RoleResource($role))->withMessage(__('view.notification.success.update'));
    }

    /**
     * Show role
     *
     * @group Role management
     * @authenticated
     */
    public function show(Role $role)
    {
        return (new RoleResource($role->load(['users','permissions'])));
    }

    /**
     * Delete role
     *
     * @group Role management
     * @authenticated
     */
    public function delete(Role $role)
    {
        $role->users()->detach();
        $role->permissions()->detach();
        $role->delete();

        return response()->json([
            'message' => __('view.notification.success.delete')
        ]);
    }
}
