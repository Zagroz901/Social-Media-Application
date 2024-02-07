<?php

namespace App\Http\Controllers;

use App\Models\Veido;
use Illuminate\Http\Request;

class VeidoController extends Controller
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
    public function store($id)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Veido  $veido
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $video = Veido::find($id);
        $video->increment('views');
        return response()->json([$video->views,'Watched success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Veido  $veido
     * @return \Illuminate\Http\Response
     */
    public function edit(Veido $veido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Veido  $veido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Veido $veido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Veido  $veido
     * @return \Illuminate\Http\Response
     */
    public function destroy(Veido $veido)
    {
        //
    }
}
