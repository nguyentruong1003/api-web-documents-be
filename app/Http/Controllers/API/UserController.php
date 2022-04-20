<?php

namespace App\Http\Controllers\API;

use App\Editors\UserEditor;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserRequest;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    /**
    * Get users
    *
    * @group User management
    * @authenticated
    */
    public function index()
    {
        return UserResource::collection(User::query()->paginate());
    }

    /**
     * Create user
     *
     * @group User management
     * @authenticated
     */
    public function create(UserRequest $request)
    {
        $user = UserEditor::open(new User())->withDataFromRequest($request)->save();
        return (new UserResource($user))->withMessage(__('view.notification.success.create'));
    }

    /**
     * Edit user
     *
     * @group User management
     * @authenticated
     */
    public function edit(UserRequest $request, User $user)
    {
        $user = UserEditor::open($user)->withDataFromRequest($request)->save();
        return (new UserResource($user))->withMessage(__('view.notification.success.update'));
    }

    /**
     * Show user
     *
     * @group User management
     * @authenticated
     */
    public function show(User $user)
    {
        return (new UserResource($user->load(['roles'])));
    }

    /**
     * Delete user
     *
     * @group User management
     * @authenticated
     */
    public function delete(User $user)
    {
        $user->roles()->detach();
        $user->delete();

        return response()->json([
            'message' => __('view.notification.success.delete')
        ]);
    }
}
