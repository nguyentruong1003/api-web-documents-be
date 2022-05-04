<?php

namespace App\Http\Controllers\API;

use App\Editors\PermissionEditor;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\PermissionRequest;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Get permissions
     *
     * @group Permission management
     * @authenticated
     */
    public function index(Request $request)
    {
        return PermissionResource::collection(Permission::query()->paginate(15));
    }

    /**
     * Create permission
     *
     * @group Permission management
     * @authenticated
     */
    public function create(PermissionRequest $request)
    {
        $permission = PermissionEditor::open(new Permission())->withDataFromRequest($request)->save();
        return (new PermissionResource($permission))->withMessage(__('view.notification.success.create'));
    }

    /**
     * Edit permission
     *
     * @group Permission management
     * @authenticated
     */
    public function edit(PermissionRequest $request, Permission $permission)
    {
        $permission = PermissionEditor::open($permission)->withDataFromRequest($request)->save();
        return (new PermissionResource($permission))->withMessage(__('view.notification.success.update'));
    }

    /**
     * Show permission
     *
     * @group Permission management
     * @authenticated
     */
    public function show(Permission $permission)
    {
        return new PermissionResource($permission);
    }

    /**
     * Delete permission
     *
     * @group Permission management
     * @authenticated
     */
    public function delete(Permission $permission)
    {
        $permission->users()->detach();
        $permission->roles()->detach();

        $permission->delete();
        return response()->json([
            'message' => __('view.notification.success.delete')
        ]);
    }
}
