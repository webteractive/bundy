<?php

namespace App\Http\Controllers;

use App\Bundy\ScrumMaster;
use Illuminate\Http\Request;

class ScrumController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScrumMaster $scrumMaster, Request $request)
    {
        return $scrumMaster->store($request->validate([
            'yesterday' => 'array|nullable',
            'blockers' => 'array|nullable',
            'today' => 'required|array'
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ScrumMaster $scrumMaster)
    {
        return $scrumMaster->todaysScrum();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ScrumMaster $scrumMaster, Request $request, $id)
    {
        return $scrumMaster->update($id, $request->validate([
            'yesterday' => 'array|nullable',
            'blockers' => 'array|nullable',
            'today' => 'required|array'
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
