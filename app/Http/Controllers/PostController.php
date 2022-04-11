<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function index()
    {
        return view('admin.post.index');
    }

    public function show($id)
    {
        $data = Post::findorfail($id);
        return view('admin.post.show', ['data' => $data]);
    }
}
