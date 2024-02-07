<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GroupPost;
use App\Models\Comment;
use App\Models\Post;
use Exception;
class GroupPostReactionController extends Controller
{
    public function index($group_id,GroupPost $post)
    {

        $likes = $post->reactions()->get();
        $count = $likes->count();
        if($count) {
            for($i=0;$i<$count;$i++) {
                try {
                    $s[]= [
                        'id' => $likes[$i]->id,
                        'first_name'=> $likes[$i]->user->first_name,
                        'last_name'=> $likes[$i]->user->last_name,
                      ];
                }catch(Exception $e) {}

             }
             return response()->json($s);
        }
        return response()->json('Likes not found');
    }
    // public function indexComment(Request $request,Comment $comment)
    // {
    //     $likes = $comment->reaction()->get();
    //     return response()->json($likes);
    // }

    public function store($group_id ,GroupPost $post )
    {
        if ($post->reactions()->where('user_id', Auth::id())->exists()){
            $post->reactions()->where('user_id', Auth::id())->delete();
        }else{

           $post->reactions()->create([
                'user_id' => Auth::id(),
            ]);
            return response()->json(["Active like"]);
        }
        return response()->json(["dislike"]);
    }


    // public function storeComment(Comment $comment) {
    //     if ($comment->reaction()->where('user_id', Auth::id())->exists()){
    //         $comment->reaction()->where('user_id', Auth::id())->delete();
    //     }else{
    //         $comment->reaction()->create([
    //             'user_id' => Auth::id()
    //         ]);
    //         return response()->json(["Active reaction"]);
    //     }
    //     return response()->json(["disreaction"]);
    // }
}
