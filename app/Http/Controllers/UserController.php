<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public static function store()
    {
        $usersCreation = User::factory()->count(20)->create();
        return $usersCreation;
    }

    public function fetch()
    {
        $users = User::all();
        return $users;
    }

    public function fetchId(Request $request)
    {
        $searchId = $request->input();
        $user = User::where('id', $searchId)->get();
        return $user;
    }
}
