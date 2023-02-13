<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = UserController::store();
        foreach ($users as $user)
        {
            DB::table('users')->insert([
                'name' => $user->{'name'},
                'email' => $user->{'email'},
                'password' => $user->{'password'}
            ]);
        }
    }
}
