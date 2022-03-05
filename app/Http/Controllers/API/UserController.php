<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    //
    public function index()
    {
        // return "Hello";
        return UserResource::collection(User::query()->paginate());
    }
}
