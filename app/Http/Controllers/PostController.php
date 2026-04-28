<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Helpers\ApiResponse;
use App\Helpers\ApiQuery;

class PostController extends Controller
{
    public function __construct()
    {
        // Auth is handled in routes
    }

    public function index()
    {
        // Delegating QueryBuilder logic to ApiQuery helper
        $posts = ApiQuery::buildPostQuery(Post::class)->paginate(10);
        
        return PostResource::collection($posts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'status' => 'in:draft,published',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);

        $post = Post::create($validated);
        $post->link = "/posts/{$post->id}";
        
        return ApiResponse::success(new PostResource($post), 'Post created successfully', 201);
    }

    public function show($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return ApiResponse::error('Post not found', 404);
        }
        return ApiResponse::success(new PostResource($post), 'Post retrieved successfully');
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return ApiResponse::error('Post not found', 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:100',
            'status' => 'sometimes|in:draft,published',
            'content' => 'sometimes|string',
            'user_id' => 'sometimes|exists:users,id'
        ]);

        $post->update($validated);
        return ApiResponse::success(new PostResource($post), 'Post updated successfully');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return ApiResponse::error('Post not found', 404);
        }

        $post->delete();
        return ApiResponse::success([
            'id' => $id,
            'deleted' => true
        ], 'Post deleted successfully');
    }
}
