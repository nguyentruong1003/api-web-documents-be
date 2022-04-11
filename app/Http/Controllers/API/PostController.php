<?php

namespace App\Http\Controllers\api;

use App\Editors\PostEditor;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
        /**
     * Get or search posts
     *
     * @group Post management
     * @authenticated
     * @queryParam name string Search by name
     */
    public function index(Request $request)
    {
        return PostResource::collection(Post::query()->paginate());
    }

    /**
     * Create post
     *
     * @group Post management
     * @authenticated
     */
    
    public function create(PostRequest $request)
    {
        $masterdata = PostEditor::open(new Post())->withDataFromRequest($request)->save();
        return (new PostResource($masterdata))->withMessage(__('view.notification.success.create'));
    }

    /**
     * Edit post
     *
     * @group Post management
     * @authenticated
     */
    public function edit(PostRequest $request, Post $post)
    {
        $post = PostEditor::open($post)->withDataFromRequest($request)->save();
        return (new PostResource($post))->withMessage(__('view.notification.success.update'));
    }

    /**
     * Show post
     *
     * @group Post management
     * @authenticated
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Delete post
     *
     * @group Post management
     * @authenticated
     */
    public function delete(Post $post)
    {
        $post->delete();
        return response()->json([
            'message' => __('view.notification.success.delete')
        ]);
    }
}
