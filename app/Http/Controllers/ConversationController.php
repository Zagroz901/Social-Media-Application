<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\ConversationAmel;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $conversations = Conversation::where('user_id', auth()->user()->id)->orWhere('seconde_user_id', auth()->user()->id)->orderBy('updated_at', 'desc')->get();
        $count = count($conversations);
        // $array = [];
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                if (isset($conversations[$i]->messages->last()->id) && isset($conversations[$j]->messages->last()->id) && $conversations[$i]->messages->last()->id < $conversations[$j]->messages->last()->id) {
                    $temp = $conversations[$i];
                    $conversations[$i] = $conversations[$j];
                    $conversations[$j] = $temp;
                }
            }
        }


        // return response()->json($conversations);
        return ConversationResource::collection($conversations);

    }



    function makConversationAsReaded(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required',
        ]);

        $conversation = Conversation::findOrFail($request['conversation_id']);

        foreach ($conversation->messages as $message) {
            $message->update(['read' => true]);
        }

        return response()->json('success', 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'seconde_user_id' => 'required',
            'message' => 'required'
        ]);
        $conversation = Conversation::create([
            'user_id' => auth()->user()->id,
            'seconde_user_id' => $request['seconde_user_id']
        ]);
        $mesage = Message::create([
            'body' => $request['message'],
            'user_id' => auth()->user()->id,
            'conversation_id' => $conversation->id,
            'read' => false,
        ]);

		return new ConversationResource($conversation);
        // return new ConversationResource($conversation);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversation $conversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation)
    {
        //
    }
}
