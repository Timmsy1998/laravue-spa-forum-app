<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ReplyResource;
use Illuminate\Support\Str;

class ReplyController extends Controller
{
    public function index(Post $post)
    {
        return ReplyResource::collection($post->replies);
    }

    public function store(Post $post, Request $request)
    {
        $reply = $post->replies()->create($request->all());
        return response(['reply' => new ReplyResource($reply)], Response::HTTP_CREATED);
    }

    public function show(Post $post, Reply $reply)
    {
        return new ReplyResource($reply);
    }

    public function update(Post $post, Request $request, Reply $reply)
    {
        $reply->update($request->all());
        return response(null, Response::HTTP_ACCEPTED);
    }

    public function destroy(Post $post, Reply $reply)
    {
        $reply->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
