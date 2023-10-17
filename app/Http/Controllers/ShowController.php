<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function showUsersFromDb()
    {
        $users = UserData::orderBy('id')->get();
        return view('show', compact('users'));
    }
}
