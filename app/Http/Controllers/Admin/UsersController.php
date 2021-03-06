<?php

namespace App\Http\Controllers\Admin;

use App\Bundy\UserManager;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        return $user->create(array_merge($request->validate([
            'role_id' => 'required',
            'last_name' => 'required',
            'first_name' => 'required',
            'dob' => 'required|date',
            'email' => 'required|email|unique:users,email',
        ]), [
            'email_verified_at' => now()->toDateTimeString()
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
            'dob' => 'required|date',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ],
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

    public function updateStataus(UserManager $user, Request $request, $id)
    {
        return $user->setStatus($id, $request->input('status'));
    }
}
