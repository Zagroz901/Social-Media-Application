<?php

namespace App\Http\Controllers;

use App\Models\GroupPostComment;
use App\Models\GroupPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class GroupPostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($group_id, GroupPost $post)
    {
        $comment = GroupPostComment::latest()->paginate(4);
        $count = $comment->count();
        if ($count) {
            for ($i = 0; $i < $count; $i++) {
                try {
                    $s[] = [
                        'id' => $comment[$i]->id,
                        'first_name' => $comment[$i]->user->first_name,
                        'last_name' => $comment[$i]->user->last_name,
                        'value_commnet' => $comment[$i]->value,
                        'post_id' => $comment[$i]->post_id,
                        'user_id' => $comment[$i]->user_id,
                        'group_id' => $group_id,
                    ];
                } catch (Exception $e) {
                }
            }
            return response()->json($s);
        }
        return response()->json('Comment not');
    }

    public function store(Request $request, $group_id , GroupPost $post)
    {
        // return response([$post]);
        $input = $request->all();
        $validate = Validator::make($input, [
            'value' => ['required', 'string', 'min:1', 'max:400']
        ]);
        if ($validate->fails()) {
            return response()->json(['failed stroed', $validate->errors()->all()]);
        }

        $comment = $post->comments()->create([
            'value' => $input['value'],
            'user_id' => Auth::id()
        ]);
        return response()->json([$comment]);
    }


    public function update(Request $request, $group_id,GroupPost $post ,$id)
    {
        $comment = GroupPostComment::query()->find($request['id']);
        if ($comment == null) {
            return response()->json(['Comment not found']);
        }
        if ($comment->user_id != Auth::id()) {
            return response()->json(['Error' => 'you do not have rights']);
        }
        $comment->update([
            'value' => $request->value
        ]);
        return response()->json([$comment, 'Commnet updated successfully']);
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


    public function destroy(Request $request,  $group_id , GroupPost $post , $id)
    {
        $commentq = GroupPostComment::query()->find($request['id']);
        if ($commentq == null) {
            return response()->json(['Comment not found']);
        }
        if ($commentq->user_id != Auth::id()) {
            return response()->json(['Error' => 'you do not have rights']);
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
