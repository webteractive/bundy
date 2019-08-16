<?php

namespace App\Http\Controllers\Admin;

use App\Bundy\Password;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPasswordsController extends Controller
{
    public function update(Request $request, Password $password, $id)
    {
        return $password->reset($id);
    }
}
