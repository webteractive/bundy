<?php

namespace App\Http\Controllers;

use App\Bundy\Password;
use App\Rules\PasswordConfirmed;
use Illuminate\Http\Request;

class PasswordsController extends Controller
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
    public function store(Request $request)
    {
        //
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
     * @param  App\Bundy\Password $password
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Password $password)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
            'current_password' => [
                'required',
                new PasswordConfirmed($request->user())
            ]
        ]);

        return $password->of($request->user())
                        ->reLogin($request->reLogin)
                        ->logoutOtherDevices($request->logoutOtherDevices)
                        ->change($request->password);
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
