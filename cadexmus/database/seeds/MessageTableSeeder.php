<?php

use Illuminate\Database\Seeder;
use App\User;
class MessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$projet_id = DB::table('projets')->where('nom', '=', 'Premier Projet')->get(['id']);
        //$user_id = DB::table('users')->where('name', '=', 'toot')->get(['id'])
        \App\Message::truncate();
        \App\Message::create(['body'=>'Salut je suis un message','projet_id'=>1,'user_id'=>1]);
        \App\Message::create(['body'=>'Je suis le 2ème utilisateur','projet_id'=>1,'user_id'=>2]);
        
    }
}
