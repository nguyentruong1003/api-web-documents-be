<?php 

namespace App\Http\Controllers\api;
use App\Editors\PostEditor;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;


class PostTypeController extends Controller 
{
    /**
     * Get or search post type
     *
     * @group Post management
     * @queryParam name string Search by name
     */
    public function index(Request $request)
    {
        return PostTypeResource::collection(Post::query()->paginate());
    }
}

