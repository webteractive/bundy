<?php

namespace App\Http\Controllers\Admin;

use App\Bundy\UserManager;
use Illuminate\Http\Request;
use App\Bundy\Response\UserList;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function index()
    {
        return new UserList();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserManager $user, Request $request)
    {
        return $user->create($request->validate([
            'role_id' => 'required',
            'last_name' => 'required',
            'first_name' => 'required',
            'email' => 'required|email',
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserManager $user, Request $request, $id)
    {
        return $user->update($id, $request->validate([
            'role_id' => 'required',
            'last_name' => 'required',
            'first_name' => 'required',
            'email' => 'required|email',
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
