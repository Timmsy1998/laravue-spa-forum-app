<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\PostResource;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(Post::latest()->paginate(5));
    }

    public function store(Request $request)
    {
        $post = auth()->user()->post()->create($request->all());
        return response(new PostResource($post), Response::HTTP_CREATED);
    }

    public function show(Post $post)
    {
        return new PostResource($post;
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        return response(null, Response::HTTP_ACCEPTED);
    }

    public function destroy(Post $post)
    {
       $post->delete();
       return response(null, Response::HTTP_NO_CONTENT);
    }

}
