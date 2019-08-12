<?php

namespace App\Http\Controllers;

use App\Bundy\Slack;
use Illuminate\Http\Request;

class SlackController extends Controller
{
    public function show(Request $request, Slack $slack)
    {
        return $slack->authorize($request->user()->username);
    }

    public function store(Request $request, Slack $slack)
    {
        return $slack->validate($request->user(), $request->only('state', 'code', 'error'));
    }
}
