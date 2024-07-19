<?php

namespace App\Http\Controllers;

// app/Http/Controllers/API/PostController.php

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::withCount(['likes', 'comments'])
            ->get();

        return response()->json($posts);
    }

    public function show($id)
    {
        $post = Post::withCount(['likes', 'comments'])
            ->findOrFail($id);

        return response()->json($post);
    }

    public function like(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
        ]);
    
        $post = Post::findOrFail($validatedData['post_id']);
    
        $like = Like::firstOrCreate([
            'user_id' => $validatedData['user_id'],
            'post_id' => $post->id,
        ]);
    
        return response()->json(['message' => 'Post liked successfully']);
    }

    public function comment(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'post_id' => 'required|exists:posts,id',
        ]);

        $post = Post::findOrFail($validatedData['post_id']);

        $comment = Comment::create([
            'user_id' => $validatedData['user_id'],
            'post_id' => $post->id,
            'content' => $validatedData['content'],
        ]);

        return response()->json($comment, 201);
    }
}
