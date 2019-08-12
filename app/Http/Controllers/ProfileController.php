<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bundy\ProfileManager;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bundy\ProfileManager  $manager
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileManager $manager, Request $request)
    {
        return $manager->update($request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => [
                'required',
                Rule::unique('users')->ignore($request->user()->id),
                'min:3'
            ],
            'bio' => 'nullable',
            'alias' => 'nullable',
            'address' => 'nullable',
            'links.*' => 'nullable|url',
            'contact_numbers' => 'nullable',
        ]));
    }
}
