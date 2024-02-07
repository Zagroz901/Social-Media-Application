<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post_Group;
use Illuminate\Http\Request;
use App\Models\Post;
use Exception;

class PostGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($group_id, Request $request, Post $post)
    {

        // $post = Post::all();
        $group = Group::find($group_id);

        if ($group_id == null) {
            return response()->json(['not found']);
        } else {
            if ($group->count() == 0) {
                return response()->json(['empty']);
            } else {
                $postgroup = Post_Group::where('group_id', '=', $group_id)->get();
                for ($i = 0; $i < $postgroup->count(); $i++) {
                    try {
                        $s[] =
                            [
                                'id' => $postgroup[$i]->id,
                                'id_post' => $postgroup[$i]->post_id,
                                'id_group' => $postgroup[$i]->group_id,
                                'post' => $postgroup[$i]->post
                            ];
                    } catch (Exception $e) {
                    }
                }
                return response()->json($s);
            }
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post_Group  $post_Group
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post_Group  $post_Group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post_Group $post_Group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post_Group  $post_Group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post_Group $post_Group)
    {
        //
    }
}
