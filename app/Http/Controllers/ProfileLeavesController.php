<?php

namespace App\Http\Controllers;

use App\Bundy\LeaveManager;
use App\Bundy\Response\ProfileLeaves;
use Illuminate\Http\Request;

class ProfileLeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ProfileLeaves();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bundy\LeaveManager  $manager
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, LeaveManager $manager)
    {
        return $manager->for($request->user())
                    ->request($request->validate([
                        'dates' => 'required',
                        'description' => 'required'
                    ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
