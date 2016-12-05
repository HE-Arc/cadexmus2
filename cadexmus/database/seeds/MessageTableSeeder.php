<?php

use Illuminate\Database\Seeder;
use App\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "body"=>"Salut je suis un message",
            "projet_id"=>DB::table('projets')->where('nom', '=', 'Premier Projet')->get(['id']),
            "user_id"=>DB::table('users')->where('name', '=', 'toot')->get(['id']),
        ]);
    }
}
