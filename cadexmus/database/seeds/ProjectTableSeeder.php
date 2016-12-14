<?php

use App\Projet;
use App\Sample;
use App\Version;
use App\User;
use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project = Projet::create(["nom"=>"Premier Projet"]);
        $users = User::all();
        $i = 1;
        foreach($users as $user)
        {
            $project->users()->attach($user, array('couleur'=> $i));
            $i++;
        }
        //$project->users()->attach(User::all(), array('couleur'=> 1));
        $samples = Sample::take(2)->get();
        $repr=[
            'tempo' => 120,
            'tracks' =>[
                [
                    "sample"=> [
                        "url" => $samples[0]->url,
                        "name" => $samples[0]->nom
                    ],
                    "notes"=>[
                        [
                            "pos"=>0,
                            "len"=>2
                        ],[
                            "pos"=>12,
                            "len"=>4,
                        ]
                    ]
                ],
                [
                    "sample"=> [
                        "url" => $samples[1]->url,
                        "name" => $samples[1]->nom
                    ],
                    "notes"=>[
                        [
                            "pos"=>16,
                            "len"=>8
                        ]
                    ],
                ],
            ],
        ];
        $project->versions()->create(["numero" => 0, "repr" => $repr]);

        $project2 = Projet::create(["nom"=>"Yolo"]);
        $users = User::all();
        $i = 1;
        foreach($users as $user)
        {
            $project2->users()->attach($user, array('couleur'=> $i));
            $i++;
        }

       // $project2->users()->attach(User::all(), array('couleur'=> 1));

        $yolorepr = '{"tempo":"90","tracks":[{"sample":{"name":"kick2","url":"samples\/native\/kick2.wav"},"notes":[{"pos":"0","len":"4"},{"pos":"12","len":"4"},{"pos":"28","len":"4"},{"pos":"20","len":"4"},{"pos":"6","len":"2"}]},{"sample":{"name":"snare1","url":"samples\/native\/snare1.wav"},"notes":[{"pos":"8","len":"4"},{"pos":"24","len":"4"}]},{"sample":{"name":"hat1","url":"samples\/native\/hat1.wav"},"notes":[{"pos":"0","len":"2"},{"pos":"4","len":"2"},{"pos":"8","len":"2"},{"pos":"12","len":"2"},{"pos":"20","len":"2"},{"pos":"24","len":"1"},{"pos":"28","len":"1"},{"pos":"16","len":"2"},{"pos":"30","len":"1"},{"pos":"26","len":"1"}]},{"sample":{"name":"hat2","url":"samples\/native\/hat2.wav"},"notes":[{"pos":"14","len":"2"},{"pos":"20","len":"2"}]}]}';
        $project2->versions()->create(["numero" => 0, "repr" => json_decode($yolorepr)]);
    }
}
