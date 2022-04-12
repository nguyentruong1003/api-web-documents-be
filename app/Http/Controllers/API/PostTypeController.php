<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostTypeResource;
use App\Models\PostType;
use Illuminate\Http\Request;

class PostTypeController extends Controller
{
    /**
     * Get post type
     *
     * @group Post type management
     */
    public function index()
    {
        return PostTypeResource::collection(PostType::query()->paginate());
    }
}
