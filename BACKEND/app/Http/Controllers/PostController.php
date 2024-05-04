<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Trait\ApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use ApiTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->validateRequest($request, [
            'page' => 'integer|min:0',
            'size' => 'integer|min:1'
        ]);
        
        $size = intval($request->input('size', 10));
        $page = intval($request->input('page', 0));

        $posts = Post::with(['user', 'attachments'])
            ->limit($size)
            ->offset($page)
            ->get();
      
        return response()->json([
            'page' => $page,
            'size' => $size,
            'posts' => $posts
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validateRequest($request, [
            'caption' => 'required',
            'attachments' => 'required|array',
            'attachments.*' => 'mimes:jpg,jpeg,webp,png,gif'
        ]);

        $post = Post::create([
            'caption' => $data['caption'],
            'user_id' => auth()->user()->id
        ]);

        foreach ($data['attachments'] as $attachment) {
            $path = $attachment->store(options: 'posts');
            $post->attachments()->create([
                'storage_path' => Storage::disk('posts')->url($path) 
            ]);    
        }

        return response()->json([
            'message' => 'Create post success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (auth()->user()->id != $post->user()->id)
        {
            return response()->json([
                "message" => "Forbidden access"
            ], 403);
        }

        $post->delete();

        return response()->json(null, 204);
    }
}
