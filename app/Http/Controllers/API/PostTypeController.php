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
        return PostTypeResource::collection(PostType::query()->paginate());
    }
    
    /**
     * Create post type
     *
     * @group Post type management
     * @authenticated
     */
    public function create(PostTypeRequest $request)
    {
        $item = PostTypeEditor::open(new PostType())->withDataFromRequest($request)->save();
        return (new PostTypeResource($item))->withMessage(__('view.notification.success.create'));
    }

    /**
     * Edit post type
     * @group Post type management
     * @authenticated
     */
    public function edit(PostTypeRequest $request, PostType $item)
    {
        $item = PostTypeEditor::open($item)->withDataFromRequest($request)->save();
        return (new PostTypeResource($item))->withMessage(__('view.notification.success.update'));
    }

    /**
     * Show post type
     *
     * @group Post type management
     */
    public function show(PostType $item)
    {
        return new PostTypeResource($item);
    }

    /**
     * Delete post type
     *
     * @group Post type management
     * @authenticated
     */
    public function delete(PostType $item)
    {
        $item->delete();
        return response()->json([
            'message' => __('view.notification.success.delete')
        ]);
    }
}
