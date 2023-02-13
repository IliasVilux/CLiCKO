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
}
