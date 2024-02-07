<?php

namespace App\Http\Controllers;

use App\Models\AddFriend;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddFriendController extends Controller
{



    // public function addFriend(User $user)
    // {
    //    $friend =  auth()->user()->addFriend($user);
    // public function addallFriend(Request $request,AddFriend $friend,User $user)
    //     {
    //         $friend = new AddFriend();
    //         $friend->friend_id= $request->friend_id;
    //         $friend->save();

    //         $friend =  auth()->user()->addallFriend($user);
    //         if($friend == null)
    //         {        return response()->json(['message'=>'already friend'],500);
    //         }
    //         return response()->json($friend);

    //     }

    //     public function isFriend(User $user)
    //     {
    //       return AddFriend::where('user_id',auth()->id)->where('friend_id',$this->id)->first();

    //     }
    //     public function removefriend(User $user)
    //     {
    //         $friend =  $user->isFriend();
    //         if($friend == null)
    //         {        return response()->json(['message'=>'you are not a friend'],500);
    //         }
    //         $friend->delete();
    //         {        return response()->json(['message'=>'suuc eremove'],500);

    //     }
    // }

    //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $input = $request->all();
        // $me = Auth::id();
        // $friend = Friend::where($me , 'user_id' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $user_requested = Auth::user()->id;
        $accesptor = $id;
        $addfriend = new AddFriend();
        $addfriend->user_requested = $user_requested;
        $addfriend->accesptor = $accesptor;
        $addfriend->save();
        return response()->json(['Done']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AddFriend  $addFriend
     * @return \Illuminate\Http\Response
     */
    public function show(AddFriend $addFriend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AddFriend  $addFriend
     * @return \Illuminate\Http\Response
     */
    public function edit(AddFriend $addFriend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AddFriend  $addFriend
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AddFriend $addFriend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AddFriend  $addFriend
     * @return \Illuminate\Http\Response
     */
    public function destroy(AddFriend $addFriend, $id)
    {
        $del = AddFriend::query();
        $del->where('accesptor', $id)->delete();
        return response()->json(['Done']);
    }
}
