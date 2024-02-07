<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comment = Comment::latest()->paginate(4);
        if($comment->count()) {
            return response()->json($comment);
        }
        return response()->json(['Comment not found']);
    }

    public function store(Request $request,Post $post,Comment $com)
    {
       // return response([$post]);
        $input = $request->all();
        $validate = Validator::make($input,[
            'value' => ['required', 'string','min:1', 'max:400']
        ]);
        if($validate->fails()) {
            return response()->json(['failed stroed', $validate->errors()->all()]);
        }
        $comment = $post->comments()->create([
            'value' => $input['value'],
            'user_id' => Auth::id()
        ]);
        return response()->json([$comment,'Comment stored successfully']);
    }


    public function update(Request $request, $id)
    {
        return $request->all();
        $comment = Comment::query()->find($request['id']);
        if($comment == null) {
            return response()->json(['Comment not found']);
        }
        if($comment->user_id != Auth::id())
        {
            return response()->json(['Error'=>'you do not have rights']);

        }
        $comment->update([
            'value' => $request->value
        ]);
        return response()->json([$comment,'Commnet updated successfully']);
 /*     $commentq = Comment::query();
        $commentq->find($request['id'])->update([
            'value' => $request->value
        ]);
        $comment = $commentq->get();
     /*   if($comment == null) {
            return response()->json(['Comment not found']);
        }*/
       // return response()->json([$comment,'Commnet updated successfully']);
    }


    public function destroy(Request $request,$id)
    {
            $commentq =Comment::query()->find($request['id']);
            if($commentq == null) {
                return response()->json(['Comment not found']);
            }
            if($commentq->user_id != Auth::id())
           {
            return response()->json(['Error'=>'you do not have rights']);
           }
            $commentq->delete();
            return response()->json(['Comment deleted successfully']);
  /*      $comment = Comment::find($id);
        if($comment===null) {
            return response()->json(['id not found']);
        }
        $comment->delete();
        return response()->json(['Comment deleted successfully']);*/
    }
}
