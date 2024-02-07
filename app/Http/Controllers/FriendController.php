<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Pagination\LengthAwarePaginato;
use Illuminate\Support\Arr;

use function PHPUnit\Framework\isEmpty;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // ------------------------------------All Your Friend Has Accepted--------------------------------------------
    public function index(Request $request, Friend $friend)
    {
        $uid = Auth::user()->id;
        $friend  = Friend::where('approved', '=', '1')->where('user_id_1', '=', $uid)->orwhere('user_id_2', '=', $uid)->where('approved', '=', '1')->get();
        $count = $friend->count();
        if ($count) {
            for ($i = 0; $i < $count; $i++) {
                if (($friend[$i]->user_id_1) == $uid) {
                    try {
                        $s[] =  [
                            'id' => $friend[$i]->id,
                            'id_user' => $friend[$i]->user2->id,
                            'first_name' => $friend[$i]->user2->first_name,
                            'last_name' => $friend[$i]->user2->last_name,
                            //   'img_url'=> $user[$i]->user->image,

                        ];
                    } catch (Exception $e) {
                    }
                } else {
                    if (($friend[$i]->user_id_2) == $uid) {
                        try {
                            $s[] =  [
                                'id' => $friend[$i]->id,
                                'id_user' => $friend[$i]->user1->id,
                                'first_name' => $friend[$i]->user1->first_name,
                                'last_name' => $friend[$i]->user1->last_name,
                                //   'img_url'=> $user[$i]->user->image,

                            ];
                        } catch (Exception $e) {
                        }
                    }
                }
            }
            return response()->json([$s, $count]);
        }
        return response()->json('You Dont Have Any Add');

        //                  try {
        //                     $s[]=  [
        //                          'id' => $friend[$i]->id,
        //                         'first_name'=> $friend[$i]->user->first_name,
        //                          'last_name'=> $friend[$i]->user->last_name,
        //                         //   'img_url'=> $user[$i]->user->image,

        //                   ];
        //                  }catch(Exception $e) {}

        //              }
        //               return response()->json([$s,$friend]);
        //         }
        //         return response()->json('You Dont Have Any Add');
        // echo $user;
    }

    // ------------------------------------Accepte A  Friend--------------------------------------------

    public  function approveRequest($friend_request_id)
    {
        $friend  =  Friend::find($friend_request_id);

        if ($friend->approved == 1) {
            return response()->json(['Already Friend']);
        } else {
            $friend->update([
                $friend->approved = 1
            ]);
            return response()->json(['Approved']);
        }
    }
    // public function index(Post $post , User $user)
    // {
    //     $post = Post::latest()->paginate(10);
    //     $count = $post->count();
    //     if($count) {
    //         for($i=0;$i<$count;$i++) {
    //             try {
    //                 $s[]= [
    //                     'id' => $post[$i]->id,
    //                     'first_name'=> $post[$i]->user->first_name,
    //                     'last_name'=> $post[$i]->user->last_name,
    //                     'value_text'=> $post[$i]->text,
    //                     'img_url'=> $post[$i]->image,
    //                     'comments_count'=>  $post[$i]->comments_count,
    //                     'reactions_count'=>  $post[$i]->reactions_count
    //                   ];
    //             }catch(Exception $e) {}

    //          }
    //           return response()->json($s);
    //     }
    //     return response()->json('Post not found');
    // }
    // ------------------------------------All Add not Accepted--------------------------------------------
    public function NotAccepted(Friend $friend)
    {
        $uid = Auth::user()->id;
        $friend  = Friend::where('approved', '=', '0')->where('user_id_1', '=', $uid)->orwhere('user_id_2', '=', $uid)->where('approved', '=', '0')->get();
        $count = $friend->count();
        // return $count;
        if ($count) {
            for ($i = 0; $i < $count; $i++) {
                if (($friend[$i]->user_id_1) == $uid) {
                    try {
                        $s[] =  [
                            'id' => $friend[$i]->id,
                            'id_user' => $friend[$i]->user2->id,
                            'first_name' => $friend[$i]->user2->first_name,
                            'last_name' => $friend[$i]->user2->last_name,
                            //   'img_url'=> $user[$i]->user->image,

                        ];
                    } catch (Exception $e) {
                    }
                } else {
                    if (($friend[$i]->user_id_2) == $uid) {
                        try {
                            $s[] =  [
                                'id' => $friend[$i]->id,
                                'id_user' => $friend[$i]->user1->id,
                                'first_name' => $friend[$i]->user1->first_name,
                                'last_name' => $friend[$i]->user1->last_name,
                                //   'img_url'=> $user[$i]->user->image,

                            ];
                        } catch (Exception $e) {
                        }
                    }
                }

            }
            return response()->json([$s, $count]);
        }
                    return response()->json(['You Dont Have Any Add']);

        //  if ($friend->count() == 0)
        //         return response()->json(['You Dont Have Any Add']);
        //     else {



        //         return response()->json([$friend, $friend->count()]);
        // }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // ------------------------------------ADD Friend--------------------------------------------
    public function store(Request $request, User $user, Friend $friend)
    {
        $friend = new Friend;
        User::find($request->user_id_2);
        if ($request->user_id_1 != Auth::id()) {
            return response()->json(['No Auth']);
        }
        $count  = Friend::all()->where('user_id_1', '=', $request->user_id_1)->where('user_id_2', '=', $request->user_id_2);
        $count2  = Friend::all()->where('user_id_1', '=', $request->user_id_2)->where('user_id_2', '=', $request->user_id_1);
        if ($count->count() > 0 or $count2->count() > 0) {
            return response()->json(['Already Friends']);
        } else {
            $friend->user_id_1 = Auth::user()->id;
            $friend->user_id_2 = $request->user_id_2;
            $friend->save();
            return response()->json(['Done']);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    // ------------------------------------Show A Friend has Accepted--------------------------------------------
    public function show(Friend $friend, $id)
    {
        $friend = Friend::find($id)->where('approved', '=', '1');
        if ($friend == null) {
            return response()->json(['Not Found']);
        }
        return response()->json([$friend, 'Done']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    // ------------------------------------Delete A Friend --------------------------------------------
    public function destroy(Friend $friend, $id)
    {
        $friend = Friend::find($id);
        if ($friend == null) {
            return response()->json(['Not Found']);
        }
        if ($friend->user_id_1 == Auth::id() || $friend->user_id_2 == Auth::id()) {
            $friend->delete();
            return response()->json(['Done']);
        }
        return response()->json(['No Auth']);
    }
}
