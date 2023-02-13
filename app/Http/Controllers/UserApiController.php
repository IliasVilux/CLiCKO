<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        $check = User::where('name', $request->name)->orWhere('email', $request->email)->first();
        if(!$check)
        {
            $newUser = User::create($request->all());
            return $newUser;
        }
        return response()->json('Name or Email already exist! Try with new credentials.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->get();
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = User::where('id', $id)->first();
        if($check)
        {
            User::destroy($id);
            return response()->json('User deleted correctly!');
        }
        return response()->json('Ups! There is no user with this ID.');
    }

    /**
     * List the top 3 mails.
     *
     * @return \Illuminate\Http\Response
     */
    public function top()
    {
        $users = User::all();
        return $users;
    }
}
