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

        $users=[
            "arnaud"=>[
                "email"=>"arnaud.droxler@he-arc.ch",
                "picture"=>"arnaud.jpg"
            ],
            "joaquim"=>[
                "email"=>"joaquim.perez@he-arc.ch",
                "picture"=>"joaquim.jpg"
            ],
            "bastien"=>[
                "email"=>"bastien.burri@he-arc.ch",
                "picture"=>"bastien.jpg"
            ]
            ];

        foreach ($users as $user => $infos){
            User::create([
                "name"=>$user,
                "email"=>$infos["email"],
                "password"=>bcrypt($user),
                "picture" => $infos["picture"],
            ]);
        }
    }
}
