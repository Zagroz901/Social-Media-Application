<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Models\User_Group;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $group = Group::all();
        $count = $group->count();
        if ($count) {
            for ($i = 0; $i < $count; $i++) {
                try {
                    $s[] =  [
                        'id_group' => $group[$i]->id,
                        'group_name' => $group[$i]->group_name,
                        'value_img' => $group[$i]->value_img,
                        'time' => ($group[$i]->created_at)->format('Y_M_D'),
                    ];
                } catch (Exception $e) {
                }
            }
            return response()->json($s);
        } else {
            return response()->json(['Empty Group']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validate = Validator::make($input, [
            'group_name' => ['required', 'string', 'min:1', 'max:50'],
            'details' => ['required', 'string', 'min:1', 'max:250']
        ]);
        if ($validate->fails()) {
            return response()->json(['failed stroed', $validate->errors()->all()]);
        }
        $group = Group::create([
            'group_name' => $input['group_name'],
            'details' => $input['details'],
            'value_img' => $input['value_img'],
            'admin_id' => Auth::id(),
        ]);
        User_Group::create([
            'user_id' => Auth::id(),
            'group_id'=> $group->id
        ]);
        return response()->json(['Group created succesfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show($id, Group $group)
    {
        $group = Group::find($id);
        if ($group == null) {
            return response()->json(['group not found']);
        } else {
            $s[] =  [
                'id_group' => $group->id,
                'group_name' => $group->group_name,
                'details' => $group->details,
                'value_img' => $group->value_img,
                'time' => ($group->created_at)->format('Y_M_D'),
                'id_admin' => $group->user3->id,
                'first_name_admin' => $group->user3->first_name,
                'last_name_admin' => $group->user3->last_name
                // 'img_admin' => $group->user3->value_img,

                // 'first_name' => $group->user->first_name,
                // 'last_name' => $group->user->last_name,
                // 'group_name'=> $group->group_name,
                // 'value_img'=> $group->value_img,
            ];
            return response()->json($s);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        // return $request->all();
        $group = Group::find($id);
        if ($group == null) {
            return response()->json(['is not exsist']);
        } else {
            $validate = Validator::make($request->all(), [
                $request->group_name => ['string', 'min:1', 'max:50'],
                $request->details => ['string', 'min:1', 'max:250'],
            ]);
            if ($validate->fails()) {
                return response()->json(['failed stroed', $validate->errors()->all()]);
            }
            if($group->admin_id == Auth::id())
            {
                $group->update([
                    'group_name' => $request->group_name,
                    'details' => $request->details,
                    'value_img' => $request->value_img
                ]);
                return response()->json(['Group updated succesfully']);
            }
            else
            return response()->json(['You Dont have a right']);


        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group, $id)
    {
        $group = Group::find($id);
        if ($group == null) {
            return response()->json(['group not found']);
        }
        if ($group->admin_id != Auth::id()) {
            return response()->json(['Error' => 'you do not have rights']);
        }
        $group->delete();
        return response()->json(['Group deleted successfully']);
    }
}
