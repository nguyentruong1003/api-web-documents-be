<?php

namespace App\Http\Controllers\API;

use App\Editors\UserEditor;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\ChangePasswordRequest;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Login
     *
     * @group Auth management
     */
    public function login(LoginRequest $request)
    {
        if (!auth()->attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Login failed',
                'errors' => [
                    'login' => __('auth.failed')
                ]
            ], 401);
        }

        $token = auth()->user()->createToken('authToken')->plainTextToken;

        return $this->respondWithToken($token);
    }

    /**
     * Register
     *
     * @group Auth management
     */
    public function register(RegisterRequest $request)
    {
        $user = UserEditor::open(new User)->withDataFromRequest($request)->save();
        $token = $user->createToken('authToken')->plainTextToken;
        return $this->respondWithToken($token, $user);
    }

    /**
     * Forgot password
     *
     * @group Auth management
     */
    public function forgotPassword()
    {
    }

    /**
     * Change password
     *
     * @group Auth management
     * @authenticated
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();
        $user->update([
            'password' => bcrypt($request->input('new_password'))
        ]);

        return (new UserResource($user))->withMessage(__('auth.changed_password'));
    }

    private function respondWithToken($token, $user = null)
    {
        if ($user == null) $user = auth()->user();
        return response()->json([
            'type' => 'Bearer',
            'token' => $token,
            'data' => new UserResource($user->load('permissions')),
            'message' => 'Logged in'
        ]);
    }

    /**
     * Get current user
     *
     * @group Auth management
     * @authenticated
     */
    public function getUser()
    {
        return new UserResource(auth()->user()->load('permissions'));
    }

    /**
     * Logout
     *
     * @group Auth management
     * @authenticated
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => __('auth.logged_out')]);
    }
}
