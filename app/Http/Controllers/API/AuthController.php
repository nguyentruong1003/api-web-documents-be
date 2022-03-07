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

    public function register(RegisterRequest $request)
    {
        $user = UserEditor::open(new User)->withDataFromRequest($request)->save();
        $token = $user->createToken('authToken')->plainTextToken;
        return $this->respondWithToken($token);
    }

    public function forgotPassword()
    {
    }

    // public function changePassword(ChangePasswordRequest $request)
    // {
    //     $user = auth()->user();
    //     $user->update([
    //         'password' => bcrypt($request->input('new_password'))
    //     ]);

    //     return (new UserResource($user))->withMessage(__('auth.changed_password'));
    // }

    private function respondWithToken($token)
    {
        return response()->json([
            'type' => 'Bearer',
            'token' => $token,
            'data' => new UserResource(auth()->user()->load('permissions')),
            'message' => 'Logged in'
        ]);
    }

    // public function getUser()
    // {
    //     return new UserResource(auth()->user()->load('permissions'));
    // }

    // public function logout()
    // {
    //     auth()->logout();
    //     return response()->json(['message' => __('auth.logged_out')]);
    // }
}
