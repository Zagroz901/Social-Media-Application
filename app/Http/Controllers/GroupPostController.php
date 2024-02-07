<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupPost;
use App\Models\GroupPostText;
use App\Models\User;
use App\Models\GroupPostVideo;
use App\Models\GroupPostImage;
use App\Models\User_Group;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use function PHPUnit\Framework\isEmpty;

class GroupPostController extends Controller
{

    public function index(GroupPost $post, User $user, $group_id, User_Group $group)
    {

        $uid  = Auth::user()->id;
        $uss = User_Group::where('user_id', '=', $uid)->get();
        if ($uss->count() == 0)
            return response()->json(['you not member']);
        else {
            $post =  GroupPost::where('group_id', '=', $group_id)->get();
            return $post;
            $count = $post->count();
            if ($count) {
                for ($i = 0; $i < $count; $i++) {
                    // try {
                    $s[] = [
                        'id' => $post[$i]->id,
                        'id_group' => $post[$i]->group_id,
                        'first_name' => $post[$i]->user->first_name,
                        'last_name' => $post[$i]->user->last_name,
                        'value_text' => $post[$i]->text,
                        'img_url' => $post[$i]->image,
                        'user_id' => $post[$i]->user_id,
                        'comments_count' =>  $post[$i]->comments_count,
                        'reactions_count' =>  $post[$i]->reactions_count
                    ];
                    //}catch(Exception $e) {}

                }
                return response()->json([$s]);
            }
            return response()->json('Post not found');
        }
    }

    public function store(GroupPost $post, Request $request, GroupPostText $text, $group_id)
    {
        $uid  = Auth::user()->id;
        $uss = User_Group::where('user_id', '=', $uid)->get();
        if ($uss->count() == 0)
            return response()->json(['you not member']);
        else {
            $input = $request->all();
            if ($input != null) {

                $post = GroupPost::create([
                    'user_id' => Auth::id(),
                    'group_id' => $group_id

                ]);
                try {
                    if ($input['value'] != null) {
                        $text = GroupPostText::create([
                            'value' => $input['value'],
                            'post_id' => $post['id']
                        ]);
                    }
                } catch (Exception $e) {
                }
                try {
                    if ($input['value_vd'] != null) {
                        GroupPostVideo::create([
                            'value_vd' => $input['value_vd'],
                            'post_id' => $post['id']
                        ]);
                    }
                } catch (Exception $e) {
                }
                try {
                    if ($input['value_img'] != null) {
                        // foreach($request->value_img as $discount) {
                        GroupPostImage::create([
                            'value_img' => $input['value_img'],
                            'post_id' => $post['id']
                        ]);
                        // }
                    }
                } catch (Exception $e) {
                }
                return response()->json(['Post Created Successfully']);
            } else {
                return response()->json(['Please input information']);
            }
        }
    }
    public function show($id, $group_id)
    {
        // return response([$p]);

        $post = GroupPost::find($id);
        return $post;
        if ($post) {
            return response()->json([$post->user->first_name]);
        }
        return response()->json(['The post not found']);
    }


    public function update(Request $request,  $group_id, $id)
    {

        $uid  = Auth::user()->id;
        $uss = User_Group::where('user_id', '=', $uid)->get();
        if ($uss->count() == 0)
            return response()->json(['you not member']);
        else {
            $input = $request->all();
            $post = GroupPost::find($id);
            //$text = Text::find();

            if ($post == null) {
                return response()->json('Post  not found');
            }
            if ($post->user_id != Auth::id()) {
                return response()->json(['Error' => 'you do not have rights']);
            }
            //  return response([$post->image]);
            if ($input['value'] == null and $input['value_vd'] == null and $input['value_img'] == null) {
                $post->delete();
                return response()->json(['The post is deleted']);
            } else {
                try {
                    if ($post->text == null and $input['value'] != null) {
                        GroupPostText::create([
                            'value' => $input['value'],
                            'post_id' => $post['id']
                        ]);
                    } else if ($post->id == $post->text->post_id and $input['value'] != null) {
                        $post->text->update([
                            'value' => $input['value']
                        ]);
                    } else if ($post->id == $post->text->post_id and $input['value'] == null) {
                        $post->text->delete();
                    }
                } catch (Exception $e) {
                }
                try {
                    if ($post->image == null and $input['value_img'] != null) {
                        GroupPostImage::create([
                            'value_img' => $input['value_img'],
                            'post_id' => $post['id']
                        ]);
                    } else if ($post->id == $post->image->post_id and $input['value_img'] != null) {
                        $post->image->update([
                            'value_img' => $input['value_img'],
                        ]);
                    } else if ($post->id == $post->image->post_id and $input['value_img'] == null) {
                        $post->image->delete();
                    }
                } catch (Exception $e) {
                }
                try {
                    if ($post->video == null and $input['value_vd'] != null) {
                        GroupPostVideo::create([
                            'value_vd' => $input['value_vd'],
                            'post_id' => $post['id']
                        ]);
                    } else if ($post->id == $post->video->post_id and $input['value_vd'] != null) {
                        $post->video->update([
                            'value_vd' => $input['value_vd'],
                        ]);
                    } else if ($post->id == $post->video->post_id and $input['value_vd'] == null) {
                        $post->video->delete();
                    }
                } catch (Exception $e) {
                }

                return response()->json(['Post Update Successfully']);
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($group_id, $id)
    {
        $uid  = Auth::user()->id;
        $uss = User_Group::where('user_id', '=', $uid)->get();
        if ($uss->count() == 0)
            return response()->json(['you not member']);
        else {
            $post = GroupPost::find($id);
            if ($post == null) {
                return response()->json('Post  not found');
            }
            if ($post->user_id != Auth::id()) {
                return response()->json(['Error' => 'you do not have rights']);
            }
            $post->delete();
            return response()->json([$post, 'Post deleted successfully']);
        }
    }
}
