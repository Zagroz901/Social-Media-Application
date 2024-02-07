<?php

namespace App\Http\Controllers;

use App\Models\GroupPostVideo;
use Illuminate\Http\Request;

class GroupPostVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\GroupPostVideo  $groupPostVideo
     * @return \Illuminate\Http\Response
     */
    public function show($id, $group_id)
    {
        $video = GroupPostVideo::find($id);
        $video->increment('views');
        return response()->json([$video->views,'Watched success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GroupPostVideo  $groupPostVideo
     * @return \Illuminate\Http\Response
     */
    public function edit(GroupPostVideo $groupPostVideo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GroupPostVideo  $groupPostVideo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroupPostVideo $groupPostVideo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroupPostVideo  $groupPostVideo
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupPostVideo $groupPostVideo)
    {
        //
    }
}
