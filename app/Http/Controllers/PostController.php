<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Text;
use App\Models\User;
use App\Models\Veido;
use App\Models\Imgae;
use App\Models\Post_Group;
use App\Models\Group;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class PostController extends Controller
{

    public function index()
    {
        // $post = Post::all();
        $post = Post::where('group_post','=','0')->latest()->paginate(10);
        if ($post->count()) {
            return response()->json($post);
        }
        return response()->json(['Post not found']);
    }

    public function store(Post $post, Request $request, Text $text, $group_id=0 , Imgae $image)
    {

        $input = $request->all();
        if ($input != null) {

            $post = Post::create([
                'user_id' => Auth::id(),
                //'post_type' => $input['post_type'],

            ]);
            if ($input['post_type'] != null) {
                $post->post_type = $input['post_type'];
                $post->save();
            }
            if ($group_id != 0) {
                $post->group_post = 1;
                $post->save();
            }
            try {
                if ($input['value'] != null) {
                    $text = Text::create([
                        'value' => $input['value'],
                        'post_id' => $post['id']
                    ]);
                }
            } catch (Exception $e) {
            }
            try {
                if ($input['value_vd'] != null) {
                    Veido::create([
                        'value_vd' => $input['value_vd'],
                        'post_id' => $post['id']
                    ]);
                }
            } catch (Exception $e) {
            }
            try {
                if ($input['value_img'] != null) {
                    // foreach($request->value_img as $discount) {
                     Imgae::create([
                        'value_img' => $input['value_img'],
                        'post_id' => $post['id']
                    ]);
                    // base64_decode($image->value_img);
                   // base64_decode($image->value_img);

                    // }
                }
            } catch (Exception $e) {
            }
            if ($group_id != null) {
            $post= Post_Group::create([
                    'post_id' => $post->id,
                    'group_id' => $group_id,
                ]);
            }
            return response()->json(['Post Created Successfully']);
        } else {
            return response()->json(['Please input information']);
        }
    }

    public function show($id, Post $p)
    {
        return response([$p]);
        $post = Post::find($id);
        if ($post) {
            return response()->json([$post]);
        }
        return response()->json(['The post not found']);
    }


    public function update(Request $request, $id)
    {
        $input = $request->all();
        $post = Post::find($id);
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
                if ($input['post_type'] != null) {
                    $post->update([
                        'post_type' => $input['post_type']
                    ]);
                }
            } catch (Exception $e) {
            }
            try {
                if ($post->text == null and $input['value'] != null) {
                    Text::create([
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
                    Imgae::create([
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
                    Veido::create([
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = post::find($id);
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
