<?php

namespace App\Http\Controllers\api;

use App\Editors\PostEditor;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\PostReportRequest;
use App\Http\Requests\API\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\File;
use App\Models\Post;
use App\Models\PostReport;
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
                'url' => $file->storeAs('/', $file->getFilename(), 'google'),
                'model_name' => Post::class,
                'model_id' => $post->id,
                'admin_id' => auth()->user()->id
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
            'data' => $report,
            'message' => 'Phản hồi thành công'
        ]);
    }

    public function download(File $file)
    {
        // return Storage::disk('google')->download($file->url);
        $dir = '/';
        $recursive = false; // Có lấy file trong các thư mục con không?
        $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
        $filename = $file->url;

        $fileDownload = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
            ->first();

        if (isset($fileDownload)) {
            return Storage::disk('google')->download($fileDownload['path']);
            // return response($rawData, 200)
            //     ->header('ContentType', $file['mimetype'])
            //     ->header('Content-Disposition', "attachment; filename='$filename'");
        } else {
            return response()->json([
                'message' => 'File not found!'
            ], 404);
        }
        
    }
}
