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

        $check = User::where('email', $request->email)->first();
        if(!$check)
        {
            $newUser = User::create($request->all());
            return $newUser;
        }
        return response()->json('This email already exist! Try with new credentials.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();
        if($user)
        {
            return $user;
        } else {
            return response()->json('No user found with ID: ' . $id);
        }
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
        $user = User::findOrFail($id);

        $reqName = $request->name;
        $reqEmail = $request->email;
        $reqMod = false;

        if($reqName && strlen($reqName) > 0)
        {
            $user->name = $reqName;
            $user->save();
            $reqMod = true;
        }
        if($reqEmail && strlen($reqEmail) > 0 && str_contains($reqEmail, '@'))
        {
            $user->email = $reqEmail;
            $user->save();
            $reqMod = true;
        }
        if ($reqMod)
        {
            return $user;
        } else {
            return response()->json('No changes were made for user with id: ' . $id);
        }
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
        $allEmails = array();
        foreach ($users as $user)
        {
            $userEmail = substr($user->email, strrpos($user->email, '@' )+1);
            array_push($allEmails, $userEmail);
        }
        $emailsCount = array_count_values($allEmails);
        asort($emailsCount);
        $top = array_reverse(array_slice($emailsCount, -3, 3));
        return $top;
    }
}
