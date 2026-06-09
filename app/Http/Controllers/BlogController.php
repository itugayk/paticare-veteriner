<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        return view('pages.blog-index', [
            'posts' => Post::published()->latest('published_at')->paginate(9),
        ]);
    }

    public function show(Post $post)
    {
        abort_unless($post->is_published, 404);

        return view('pages.blog-show', [
            'post' => $post,
            'related' => Post::published()
                ->where('id', '!=', $post->id)
                ->where('category', $post->category)
                ->latest('published_at')
                ->take(2)
                ->get(),
        ]);
    }
}
