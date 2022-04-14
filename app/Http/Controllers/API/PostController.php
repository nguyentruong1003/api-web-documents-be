<?php

namespace App\Http\Controllers\api;

use App\Editors\PostEditor;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\File;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Get or search posts
     *
     * @group Post management
     * @queryParam name string Search by title, type, content
     */
    public function index(Request $request)
    {
        $query = Post::query();
        if (isset($request->title)) {
            $query->where('title', 'like', '%' . trim(removeStringUtf8($request->name)) . '%');
        }
        else if (isset($request->type)) {
            $query->where('post_type_id', 'like', '%' . trim(removeStringUtf8($request->type)) . '%');
        }
        else if (isset($request->content)) {
            $query->where('content', 'like', '%' . trim(removeStringUtf8($request->content)) . '%');
        }
        return PostResource::collection($query->paginate(25));
    }

    /**
     * Create post
     *
     * @group Post management
     * @authenticated
     */
    public function create(PostRequest $request)
    {
        $files = $request->file('files');
        $allowedfileExtension=['pdf'];
        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();
            if (! in_array($extension, $allowedfileExtension)) {
                return response()->json(['Invalid file format, only accept file pdf'], 422);
            }
        }
        $post = PostEditor::open(new Post())->withDataFromRequest($request)->save();
        foreach ($files as $file) {
            $tmp = File::query()->create([
                'file_name' => $file->getClientOriginalName(),
                'size_file' => getFileSize($file),
                'url' => $file->store('public/files'),
                'model_name' => Post::class,
                'model_id' => $post->id,
                'user_id' => auth()->user()->id
            ]);
        }
        return (new PostResource($post))->withMessage(__('view.notification.success.create'));
    }

    /**
     * Edit post
     * @bodyParam title string required The title of the post.
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
