<?php

namespace App\Http\Controllers;

use App\Bundy\Fence;
use Illuminate\Http\Request;

class WorkingRemoteController extends Controller
{
    public function update(Request $request)
    {
        return (new Fence($request->ip()))
                    ->withUser($request->user())
                    ->updateReason($request->validate([
                        'reason' => 'required'
                    ]));
    }
}
