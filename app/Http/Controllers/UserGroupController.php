<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Models\User_Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $group_id, User $user)
    {
        if ($group_id == null) {
            return response()->json(['NO']);
        } else {
            $group = Group::find($group_id);
            if ($group == null) {
                return response()->json('No Found A group');
            } else {
                $group = User_Group::where('group_id', '=', $group_id)->get();
                $count = $group->count();
                if ($count) {
                    for ($i = 0; $i < $count; $i++) {
                        try {
                            $s[] =  [
                                'id_group' => $group[$i]->group->id,
                                'group_name' => $group[$i]->group->group_name,
                                'id_user' => $group[$i]->user->id,
                                'first_name' => $group[$i]->user->first_name,
                                'last_name' => $group[$i]->user->last_name,
                                'join_in' => $group[$i]->created_at->format('Y_M_D'),
                                // 'img_url' => $group[$i]->user->img_url,
                            ];
                        } catch (Exception $e) {
                        }
                    }
                    return response()->json($s);
                }
                return response()->json('Dont Have Any Member');
            }
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $group_id, Group $group)
    {
        if ($group_id == null) {
            return response()->json(['NO']);
        } else {
            $group = Group::find($group_id);
            if ($group != null) {
                if ($group->admin_id == Auth::id()) {
                    User_Group::create([
                        'group_id' => $group_id,
                        'user_id' => $request->user_id
                    ]);
                    return response()->json(['Done']);
                }
            } else
                return response()->json(['Group Not Found']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User_Group  $user_Group
     * @return \Illuminate\Http\Response
     */
    public function show(User_Group $user_Group)
    {
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User_Group  $user_Group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $group_id)
    {
        // echo $request->user_id;
        if ($group_id == null) {
            return "No";
        } else {
            $group = Group::find($group_id);
            if ($group != null) {
                if ($group->admin_id = Auth::id()) {
                    $user =   User_Group::where('user_id', '=', $request->user_id)->where('group_id', '=', $group_id)->delete();
                    return response()->json(['Done']);
                }
            }
            else
            return response()->json(['Not Found']);

        }
    }
}
