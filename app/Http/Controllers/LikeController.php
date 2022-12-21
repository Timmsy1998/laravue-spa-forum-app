<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LikeController extends Controller
{
    public function store(Reply $reply)
    {
        $reply->like()->create([
            'user_id' => auth()->id()
        ]);
    }

    public function destroy(Reply $reply)
    {
        $reply->like()->where('user_id', auth()->id())->first()->delete();

    }
}
