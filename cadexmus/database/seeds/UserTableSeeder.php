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
            "name"=>"toot",
            "email"=>"asd.asd@asd.asd",
            "password"=>bcrypt("toot"),
            "picture" => "default.jpg",
        ]);

        $emails=["arnaud"=>"arnaud.droxler@he-arc.ch",
            "joaquim"=>"joaquim.perez@he-arc.ch",
            "bastien"=>"bastien.burri@he-arc.ch",
            "picture" => "default.jpg",
            ];

        foreach ($emails as $user => $email){
            User::create([
                "name"=>$user,
                "email"=>$email,
                "password"=>bcrypt($user),
                "picture" => "default.jpg",
            ]);
        }
    }
}
