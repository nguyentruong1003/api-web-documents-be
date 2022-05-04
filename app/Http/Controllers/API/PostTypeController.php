<?php

namespace App\Http\Controllers\API;

use App\Editors\PostTypeEditor;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\PostTypeRequest;
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
        return PostTypeResource::collection(PostType::query()->where('parent_id', null)->paginate(15));
    }
    
    /**
     * Create post type
     *
     * @group Post type management
     * @authenticated
     */
    public function create(PostTypeRequest $request)
    {
        $posttype = PostTypeEditor::open(new PostType())->withDataFromRequest($request)->save();
        return (new PostTypeResource($posttype))->withMessage(__('view.notification.success.create'));
    }

    /**
     * Edit post type
     * @group Post type management
     * @authenticated
     */
    public function edit(PostTypeRequest $request, PostType $posttype)
    {
        $posttype = PostTypeEditor::open($posttype)->withDataFromRequest($request)->save();
        return (new PostTypeResource($posttype))->withMessage(__('view.notification.success.update'));
    }

    /**
     * Show post type
     *
     * @group Post type management
     */
    public function show(PostType $posttype)
    {
        return new PostTypeResource($posttype);
    }

    /**
     * Delete post type
     *
     * @group Post type management
     * @authenticated
     */
    public function delete(PostType $posttype)
    {
        $posttype->delete();
        return response()->json([
            'message' => __('view.notification.success.delete')
        ]);
    }
}
