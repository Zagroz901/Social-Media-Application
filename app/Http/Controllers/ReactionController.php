<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Reaction;
class ReactionController extends Controller
{
    public function index(Request $request,Post $post)
    {
        $likes = $post->reactions()->get();
        return response()->json($likes);
    }
    public function indexComment(Request $request,Comment $comment)
    {
        $likes = $comment->reaction()->get();
        return response()->json($likes);
    }

    public function store(Request $request, Post $post)
    {
        if ($post->reactions()->where('user_id', Auth::id())->exists()){
            $post->reactions()->where('user_id', Auth::id())->delete();
        }else{
            $post->reactions()->create([
                'user_id' => Auth::id()
            ]);
            return response()->json(["Active like"]);
        }
        return response()->json(["dislike"]);
    }
    public function storeComment(Comment $comment) {
        if ($comment->reaction()->where('user_id', Auth::id())->exists()){
            $comment->reaction()->where('user_id', Auth::id())->delete();
        }else{
            $comment->reaction()->create([
                'user_id' => Auth::id()
            ]);
            return response()->json(["Active reaction"]);
        }
        return response()->json(["disreaction"]);
    }
}
