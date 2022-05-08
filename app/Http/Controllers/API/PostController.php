<?php

namespace App\Http\Controllers\api;

use App\Editors\PostEditor;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CommentRequest;
use App\Http\Requests\API\PostReportRequest;
use App\Http\Requests\API\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\File;
use App\Models\Post;
use App\Models\PostReport;
use App\Models\PostType;
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
            $query->where('unsign_text', 'like', '%' . strtolower(trim(removeStringUtf8($request->title))) . '%');
        }
        if (isset($request->type)) {
            $post_type = PostType::where('slug', $request->type)->first();
            if (isset($post_type)) {
                // if (isset($post_type->children)) {
                //     foreach ($post_type->children as $item) {
                //         $query->orwhere('post_type_id', $item->id);
                //     }
                // } else
                    $query->where('post_type_id', $post_type->id);
            }
        }
        if (isset($request->content)) {
            $query->where('content', 'like', '%' . trim(removeStringUtf8($request->content)) . '%');
        }
        return PostResource::collection($query->paginate(15));
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
        if (isset($files)) {
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
                    'url' => $file->storeAs('/', $file->getClientOriginalName(), 'google'),
                    'model_name' => Post::class,
                    'model_id' => $post->id,
                    'admin_id' => auth()->user()->id
                ]);
            }
        } else {
            $post = PostEditor::open(new Post())->withDataFromRequest($request)->save();
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
        if (checkAdminOrAuthor($post->user_id)) {
            $post = PostEditor::open($post)->withDataFromRequest($request)->save();
            return (new PostResource($post))->withMessage(__('view.notification.success.update'));
        } else {
            return response()->json([
                'message' => 'You are not allowed to do this',
            ], 403);
        }
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
        if (checkAdminOrAuthor($post->user_id)) {
            $post->delete();
            return response()->json([
                'message' => __('view.notification.success.delete')
            ]);
        } else {
            return response()->json([
                'message' => 'You are not allowed to do this',
            ], 403);
        }
    }

    /**
     * Like post
     * @group Post management
     * @authenticated
     */
    public function like(Post $post)
    {
        $users = $post->likes->pluck('id')->toArray();
        if (!in_array(auth()->user()->id, $users)) {
            $post->likes()->attach(auth()->user()->id);
            return response()->json([
                'message' => 'Like'
            ]);
        } else {
            $post->likes()->detach(auth()->user()->id);
            return response()->json([
                'message' => 'Unlike'
            ]);
        }
    }

    /**
     * Report post
     * @group Post management
     * @authenticated
     */
    public function report(PostReportRequest $request, Post $post)
    {
        $report = PostReport::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'description' => $request->description,
        ]);
        
        return response()->json([
            'data' => PostReport::findorfail($report->id),
            'message' => 'Phản hồi thành công'
        ]);
    }

    /**
     * Download File
     * @group Post management
     */

    public function download(File $file)
    {
        $fileDownload = getFileOnGoogleDriveServer($file->id);
        if (isset($fileDownload)) {
            return Storage::disk('google')->download($fileDownload['path']);
        } else {
            return response()->json([
                'message' => 'File not found!'
            ], 404);
        }
        
    }

    /**
     * Comment to post
     * @group Post management
     * @authenticated
     */

    public function comment(CommentRequest $request, Post $post)
    {
        $comment = Comment::create([
            'comment' => $request->comment,
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'parent_id' => $request->parent_id ?? null,
        ]);
        
        return response()->json([
            'data' => Comment::findorfail($comment->id),
            'message' => 'Thành công.'
        ]);
    }

    /**
     * Edit commet
     * @group Post management
     * @authenticated
     */

    public function editComment(CommentRequest $request, Post $post, Comment $comment)
    {
        if (checkAdminOrAuthor($comment->user_id)) {
            Comment::findorfail($comment->id)->update([
                'comment' => $request->comment,
                'user_id' => auth()->user()->id,
                'post_id' => $post->id,
                'parent_id' => $request->parent_id ?? null,
            ]);
            
            return response()->json([
                'data' => Comment::findorfail($comment->id),
                'message' => 'Thành công.'
            ]);
        } else {
            return response()->json([
                'message' => 'You are not allowed to do this',
            ], 403);
        }
    }

    /**
     * Delete comment
     * @group Post management
     * @authenticated
     */

    public function deleteComment(Post $post, Comment $comment)
    {
        if (checkAdminOrAuthor($comment->user_id)) {
            $comment->delete();
            return response()->json([
                'message' => __('view.notification.success.delete')
            ]);
        } else {
            return response()->json([
                'message' => 'You are not allowed to do this',
            ], 403);
        }
    }

    /**
     * Like comment
     * @group Post management
     * @authenticated
     */

    public function likeComment(Post $post, Comment $comment)
    {
        $users = $comment->likes->pluck('id')->toArray();
        if (!in_array(auth()->user()->id, $users)) {
            $comment->likes()->attach(auth()->user()->id);
            return response()->json([
                'message' => 'Like'
            ]);
        } else {
            $comment->likes()->detach(auth()->user()->id);
            return response()->json([
                'message' => 'Unlike'
            ]);
        }
    }
}
